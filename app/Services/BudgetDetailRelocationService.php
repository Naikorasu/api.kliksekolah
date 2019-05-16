<?php

namespace App\Services;

use Auth;
use GuzzleHttp\MessageFormatter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\WorkflowService;
use App\Services\BudgetDetailService;
use App\BudgetDetailDraft;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\DataSaveFailureException;
use App\Exceptions\FundRequestExceedRemainsException;
use App\BudgetRelocation;
use App\BudgetRelocationRecipients;
use App\BudgetRelocationSources;


class BudgetDetailRelocationService extends BaseService {

  private $budgetDetailService;

  public function __construct(BudgetDetailService $budgetDetailService) {
    $this->budgetDetailService = $budgetDetailService;
  }

  public function list($filters=[]) {
    $conditions = $this->buildFilters($filters);
    return BudgetRelocation::where($conditions)->get();
  }

  public function get($id) {
    try {
      $budgetRelocation = BudgetRelocation::with('budgetRelocationSources', 'budgetRelocationRecipients')->findOrFail($id);
      return $budgetRelocation;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function save($sources, $recipients, $head, $account, $id=null) {
    $budgetRelocation = BudgetRelocation::updateOrCreate(['user_id' => Auth::user()->id, 'id' => $id]);

    if(isset($id)) {
      try {
        $budgetRelocation = $budgetRelocation->findOrFail($id);
      } catch (ModelNotFoundException $exception) {
        throw new DataNotFoundException($exception->getMessage());
      }
    }

    $budgetDetailRelocationSources = [];
    $budgetDetailRelocationRecipients = [];

    foreach($sources as $index => $source) {
      $sources[$index] = $source =  new BudgetRelocationSources($source);
      $this->validateAmount($source->budget_detail_unique_id, $source->relocated_amount);
    }

    $budgetRelocation->budgetRelocationSources()->saveMany($sources);

    foreach ($recipients as $index => $recipient) {
      $recipient = array_merge(['head'=>$head, 'user_id'=>Auth::user()->id, 'account'=>$account], (array) $recipient);

      $budgetDetailDraft = BudgetDetailDraft::updateOrCreate($recipient);
      $recipients[$index] =  new BudgetRelocationRecipients([
        'allocated_amount' => $budgetDetailDraft->total,
        'budget_detail_id' => $budgetDetailDraft->id,
        'description' => isset($budgetDetailDraft->descripton) ? $budgetDetailDraft->description : '',
        'is_draft' => true
      ]);
    }

    $budgetRelocation->budgetRelocationRecipients()->saveMany($recipients);

    return $budgetRelocation->load('budgetRelocationSources','budgetRelocationRecipients');
  }

  public function submit($id) {
    try {
      $budgetRelocation = BudgetRelocation::findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
    $budgetRelocation->update(['submitted'=>true]);
    return $budgetRelocation;
  }

  public function updateStatus($id, $status=false) {
    try {
      $budgetRelocation = BudgetRelocation::findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
    $budgetRelocation->update(['approved'=>$status]);
    return $budgetRelocation;
  }

  private function validateAmount($budgetDetailId, $allocation) {
    try {
      $budgetDetail = $this->budgetDetailService->get($budgetDetailId, true);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }

    if(isset($budgetDetail->remains) && $budgetDetail->remains < $allocation) {
      throw new FundRequestExceedRemainsException($budgetDetail->remains, $allocation);
    }
  }
}
