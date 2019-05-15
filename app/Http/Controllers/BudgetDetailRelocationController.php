<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BudgetDetail;
use App\BudgetRelocation;
use App\BudgetRelocationSources;
use App\BudgetRelocationRecipients;
use Auth;
use App\Services\BudgetDetailRelocationService;

class BudgetDetailRelocationController extends Controller
{

  private $budgetbudgetDetailRelocationService;

  public function __construct(BudgetDetailRelocationService $budgetDetailRelocationService) {
      $this->budgetDetailRelocationService = $budgetDetailRelocationService;
  }

  public function list(Request $request) {
    $budgetRelocation = BudgetRelocation::where(budget_detail_unique_id, $request->budget_detail_unique_id)->get();
    if($budgetRelocation) {
      return response()->json([
        data => $budgetRelocation
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

    $data = $this->budgetDetailRelocationService->save($request->sources, $request->recipients, $request->head, $request->account, $request->id);

    return response()->json([
      'message' => 'Successfully saved budget relocation',
      'data' => $data
    ],200);
  }

  public function submit(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $budgetRelocation = BudgetRelocation::with('budgetRelocationSources', 'budgetRelocationRecipients')->find($request->id);

      $totalAllocation = 0;
      $totalRelocation = 0;

      $sources = [];
      $recipients = [];
      foreach($budgetRelocation->budgetRelocationSources as $source) {
          $budgetDetail = BudgetDetail::withRemains()->where('unique_id',$source->budget_detail_unique_id)->first();

          if($source->relocated_amount > $budgetDetail->remains) {
            return response()->json([
              'message' => 'Failed submitting budget relocation. One of the relocated amount is bigger than available amount.',
              'data' => $budgetDetail
            ],400);
          }

          $totalRelocation += $budgetDetail->remains;
      }

      foreach($budgetRelocation->budgetRelocationRecipients as $recipients) {
        if($recipient->is_draft) {

        }
      }
      //validate $amount

  }

  public function updateApproval(Request $request) {
    $budgetRelocation = BudgetRelocation::where('id', $request->id)->get();
    if($budgetRelocation) {
      $sourceBudgetDetail = BudgetDetail::where('budget_detail_unique_id', $budgetRelocation->source_unique_id)->get();
      $destinationBudgetDetail = BudgetDetail::where('budget_detail_unique_id', $budgetRelocation->destination_unique_id)->get();

      $sourceBudgetDetail->update([total => $sourceBudgetDetail->total - $budgetRelocation->amount]);
      $destinationBudgetDetail->update([total => $destinationBudgetDetail->total + $budgetRelocation->amount]);

      $budgetRelocation->update([status => true]);

      return response()->json([
        'message' => 'Successfully relocated' . $request->amount. 'from' .$request->source_unique_id. 'to' .$request->destination_unique_id
      ],200);

    } else {
      return response()->json([
        'message' => 'Failed to update status. Requested resource is not found.'
      ], 400);
    }
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
  //   $budgetRelocation = new BudgetRelocation();
  //   $budgetRelocation->head = $request->head;
  //   $budgetRelocation->account = $request->account;
  //   $budgetRelocation->save();
  //
  //   foreach($sources as $source) {
  //     $sourceBudgetDetail = BudgetDetail::withRemains()->select('remains','unique_id')->find('unique_id',$source->unique_id);
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
  //       $recipientBudgetDetail = BudgetDetail::select('unique_id')->find('unique_id', $recipient->unique_id);
  //     } else {
  //       $recipientBudgetDetail = new BudgetDetailDraft($recipient);
  //       $recipientBudgetDetail->head = $request->head;
  //       $recipientBudgetDetail->account = $request->$account;
  //       $recipientBudgetDetail->save();
  //       $is_draft = true;
  //     }
  //
  //     $budgetRelocationRecipient = new BudgetRelocationRecipients();
  //     $budgetRelocationRecipient->budget_relocation_id = $budgetRelocation->id;
  //     $budgetRelocationRecipient->budget_detail_id = $recipientBudgetDetail->unique_id;
  //     $budgetRelocationRecipient->allocated_amount = $recipient->allocated_amount;
  //     $budgetRelocationRecipient->save();
  //   }
  //
  //   $budgetRelocation->load('budgetRelocationSources','budgetRelocationRecipients');
  //
  //   return $budgetRelocation;
  // }


}
