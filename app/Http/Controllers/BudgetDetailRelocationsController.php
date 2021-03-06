<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BudgetDetails;
use App\BudgetRelocations;
use App\BudgetRelocationSources;
use App\BudgetRelocationRecipients;
use Auth;
use App\Services\BudgetDetailRelocationsService;

class BudgetDetailRelocationsController extends Controller
{

  private $budgetDetailRelocationService;

  public function __construct(BudgetDetailRelocationsService $budgetDetailRelocationService) {
      $this->budgetDetailRelocationService = $budgetDetailRelocationService;
  }

  public function get(Request $request) {
    $request->validate([
      'id' => 'required'
    ]);

    $budgetRelocation = $this->budgetDetailRelocationService->get($request->id);
    return response()->json([
      'data' => $budgetRelocation
    ]);
  }

  public function list(Request $request) {
    $filters = (isset($request->filters)) ? $request->filters : [];

    $budgetRelocation = $this->budgetDetailRelocationService->list($filters, $request->unit_id);

    if($budgetRelocation) {
      return response()->json([
        'data' => $budgetRelocation
      ], 200);
    } else {
      return response()->json([
        'message' => 'Failed to find budget relocation with budget detail unique id:'.$request->budget_detail_unique_id
      ],400);
    }
  }

  /** Add budget relocation
    * @source typeof Array
    * @destination typeof Array
  **/
  public function save(Request $request) {
    $request->validate([
        'head' => 'required',
        'account' => 'required',
        'sources' => 'required|array',
        'sources.*.budget_detail_unique_id' => 'required',
        'sources.*.relocated_amount' => 'required',
        'recipients' => 'required|array'
    ]);

    $data = $this->budgetDetailRelocationService->save($request->sources, $request->recipients, $request->head, $request->account, $request->description, $request->id, $request->unit_id);

    return response()->json([
      'message' => 'Successfully saved budget relocation',
      'data' => $data
    ],200);
  }

  public function submit(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $data = $this->budgetDetailRelocationService->submit($request->id);

      return response()->json([
        'message' => 'Successfully saved budget relocation',
        'data' => $data
      ],200);
  }

  public function updateStatus(Request $request, $status) {
    $request->validate([
      'id' => 'required'
    ]);

    $this->budgetDetailRelocationService->updateStatus($request->id, $status);
    return response()->json([
      'message' => 'Successfully relocated budget'
    ],200);
  }

  public function delete(Request $request) {
    $request->validate([
      'id' => 'required'
    ]);
    $budgetRelocation = $this->budgetDetailRelocationService->delete($request->id);
    return response()->json([
      'message' => 'Budget relocation has been successully deleted',
      'data' => $budgetRelocation
    ]);
  }

  // private function save(Request $request) {
  //   $request->validate([
  //     'sources' => 'required|array|min:1',
  //     'sources.*.unique_id' => 'required',
  //     'recipients' => 'required|array|min:1',
  //     'head' => 'required',
  //     'account' => 'required'
  //   ]);
  //
  //   $sources = $request->sources;
  //   $recipients = $request->recipients;
  //
  //   $budgetRelocation = new BudgetRelocations();
  //   $budgetRelocation->head = $request->head;
  //   $budgetRelocation->account = $request->account;
  //   $budgetRelocation->save();
  //
  //   foreach($sources as $source) {
  //     $sourceBudgetDetails = BudgetDetails::withRemains()->select('remains','unique_id')->find('unique_id',$source->unique_id);
  //
  //     $budgetRelocationSource = new BudgetRelocationSources();
  //     $budgetRelocationSource->budget_relocation_id = $budgetRelocation->id;
  //     $budgetRelocationSource->budget_detail_unique_id = $source->budget_detail_unique_id;
  //     $budgetRelocationSource->relocated_amount = $source->relocated_amount;
  //     $budgetRelocationSource->description = $source->description;
  //     $budgetRelocationSource->save();
  //   }
  //
  //   foreach($recipients as $recipient) {
  //     $is_draft = false;
  //     if($recipient->unique_id) {
  //       $recipientBudgetDetails = BudgetDetails::select('unique_id')->find('unique_id', $recipient->unique_id);
  //     } else {
  //       $recipientBudgetDetails = new BudgetDetailDrafts($recipient);
  //       $recipientBudgetDetails->head = $request->head;
  //       $recipientBudgetDetails->account = $request->$account;
  //       $recipientBudgetDetails->save();
  //       $is_draft = true;
  //     }
  //
  //     $budgetRelocationRecipient = new BudgetRelocationRecipients();
  //     $budgetRelocationRecipient->budget_relocation_id = $budgetRelocation->id;
  //     $budgetRelocationRecipient->budget_detail_id = $recipientBudgetDetails->unique_id;
  //     $budgetRelocationRecipient->allocated_amount = $recipient->allocated_amount;
  //     $budgetRelocationRecipient->save();
  //   }
  //
  //   $budgetRelocation->load('budgetRelocationSources','budgetRelocationRecipients');
  //
  //   return $budgetRelocation;
  // }


}
