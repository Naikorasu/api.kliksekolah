<?php

namespace App\Services;

use Auth;
use GuzzleHttp\MessageFormatter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\WorkflowService;
use App\Services\BudgetDetailsService;
use App\BudgetDetailDrafts;
use App\Exceptions\ApprovalException;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\DataSaveFailureException;
use App\Exceptions\FundRequestsExceedRemainsException;
use App\Budgets;
use App\BudgetDetails;
use App\BudgetRelocations;
use App\BudgetRelocationRecipients;
use App\BudgetRelocationSources;


class BudgetDetailRelocationsService extends BaseService {

  private $budgetDetailService;

  public function __construct(BudgetDetailsService $budgetDetailService) {
    $this->budgetDetailService = $budgetDetailService;
  }

  public function list($filters=[], $unit_id = null) {
    $conditions = $this->buildFilters($filters);

    if(!isset($unit_id)) {
      $user = Auth::user();
      $unit_id = $user->prm_school_units_id;
      if(!isset($unit_id) && isset($user->prm_perwakilan_id)) {
        $unit_id = SchoolUnits::select('id')->where('prm_perwakilan_id', $user->prm_perwakilan_id)->get();
      }
    }

    $budgetRelocations = BudgetRelocations::withUnitId($unit_id)->with('head')->totalPengajuan()->orderBy('created_at','DESC')->where($conditions)->get();
    $data = $budgetRelocations->transform(function($budgetRelocation) {
      return [
        'id' => $budgetRelocation->id,
        'no_pengajuan' => $budgetRelocation->nomor_pengajuan,
        'created_at' => $budgetRelocation->created_at,
        'description' => $budgetRelocation->description,
        'total' => $budgetRelocation->total,
        'submitted' => $budgetRelocation->submitted,
        'head' => $budgetRelocation->head
      ];
    });
    return $data;
  }

  public function get($id) {
    try {
      $budgetRelocation = BudgetRelocations::with('head', 'budgetRelocationSources', 'budgetRelocationRecipients', 'budgetRelocationSources.budgetDetail', 'budgetRelocationRecipients.budgetDetailDraft', 'budgetRelocationSources.budgetDetail.parameter_code', 'budgetRelocationRecipients.budgetDetailDraft.parameter_code')->findOrFail($id);
      return $budgetRelocation;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function save($sources, $recipients, $head, $account, $description = '', $id=null, $unit_id = null) {
    if(isset($id)) {
      try {
        $budgetRelocation = BudgetRelocations::findOrFail($id);
      } catch (ModelNotFoundException $exception) {
        throw new DataNotFoundException($exception->getMessage());
      }
    } else {
      $budgetRelocation = new BudgetRelocations();
      $budgetRelocation->nomor_pengajuan = 'PA'.date('m').date('Y').date('H').date('i').date('s');
    }

    $budget = Budgets::find($head);

    $budgetRelocation->user_id = Auth::user()->id;
    $budgetRelocation->account = $account;
    $budgetRelocation->description = $description;
    $budgetRelocation->head = $budget['id'];
    $budgetRelocation->save();

    $budgetDetailRelocationSources = [];
    $budgetDetailRelocationRecipients = [];

    $totalRelocatedAmount = 0;

    foreach($sources as $index => $source) {
      $source['budget_relocation_id'] = $budgetRelocation->id;
      $sources[$index] = $source =  new BudgetRelocationSources($source);
      $this->validateAmount($source->budget_detail_unique_id, $source->relocated_amount);
      $totalRelocatedAmount += $source->relocated_amount;
    }

    $budgetRelocation->budgetRelocationSources()->forceDelete();
    $budgetRelocation->budgetRelocationSources()->saveMany($sources);

    $totalAllocatedAmount = 0;
    foreach ($recipients as $index => $recipient) {
      $recipient = array_merge(['head'=>$budget['id'], 'user_id'=>Auth::user()->id, 'account'=>$account], (array) $recipient);

      $budgetDetailDraft = BudgetDetailDrafts::updateOrCreate($recipient,$recipient);
      $recipients[$index] =  new BudgetRelocationRecipients([
        'allocated_amount' => $budgetDetailDraft->total,
        'budget_detail_id' => $budgetDetailDraft->id,
        'description' => isset($budgetDetailDraft->descripton) ? $budgetDetailDraft->description : '',
        'is_draft' => true
      ]);

      if($budgetDetailDraft->total > $totalRelocatedAmount) {
        throw new FundRequestsExceedRemainsException($totalRelocatedAmount, $budgetDetailDraft->total);
      }

      $totalAllocatedAmount = $budgetDetailDraft->total;
    }

    if($totalAllocatedAmount > $totalRelocatedAmount) {
      throw new FundRequestsExceedRemainsException($totalRelocatedAmount, $totalAllocatedAmount);
    }

    $budgetRelocation->budgetRelocationRecipients()->forceDelete();
    $budgetRelocation->budgetRelocationRecipients()->saveMany($recipients);

    $this->updateEntityUnit($budgetRelocation, $unit_id);

    return $budgetRelocation->load('budgetRelocationSources','budgetRelocationRecipients');
  }

  public function submit($id) {
    try {
      $budgetRelocation = BudgetRelocations::findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
    $budgetRelocation->update(['submitted'=>true]);
    return $budgetRelocation;
  }

  public function delete($id) {
    $budgetRelocation = BudgetRelocations::findOrFail($id);
    $budgetRelocation->budgetRelocationSources()->delete();
    $budgetRelocation->budgetRelocationRecipients()->delete();
    $budgetRelocation->delete();

    return $budgetRelocation;
  }

  public function updateStatus($id, $type=false) {
    try {
      $budgetRelocation = BudgetRelocations::where('approved',false)->findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new ApprovalException($exception->getMessage(), $type, $id);
    }

    $budgetRelocation->update(['approved' => ($type == 'approve') ? true : false]);
    if($type == 'approve') {
      $budgetRelocationSources = BudgetRelocationSources::where('budget_relocation_id', $budgetRelocation->id);
      foreach($budgetRelocationSources as $source) {
        $this->validateAmount($source->budget_detail_unique_id, $source->relocated_amount);
      }

      $budgetDetailRelocationRecipients = BudgetRelocationRecipients::where('budget_relocation_id',$budgetRelocation->id)->get();
      foreach($budgetDetailRelocationRecipients as $recipient) {
        $budgetDetailDraft = BudgetDetailDrafts::find($recipient->budget_detail_id);
        $budgetDetail = $this->budgetDetailService->save($budgetDetailDraft->toArray(), $budgetRelocation->head, $budgetRelocation->account, $budgetDetailDraft->accountType);
        $recipient->update(['budget_detail_id' => $budgetDetail->unique_id, 'is_draft' => false]);
        dd($recipient);
      }
    }
    return $budgetRelocation;
  }

  private function validateAmount($budgetDetailId, $allocation) {
    try {
      $budgetDetail = $this->budgetDetailService->get($budgetDetailId, true);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }

    if(isset($budgetDetail->remains) && $budgetDetail->remains < $allocation) {
      throw new FundRequestsExceedRemainsException($budgetDetail->remains, $allocation);
    }
  }
}
