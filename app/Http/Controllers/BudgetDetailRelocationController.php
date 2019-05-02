<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BudgetDetail;
use App\BudgetDetailRelocation;

class BudgetDetailRelocationController extends Controller
{
  public function list(Request $request) {
    $budgetDetailRelocation = BudgetDetailRelocation::where(budget_detail_unique_id, $request->budget_detail_unique_id)->get();
    if($budgetDetailRelocation) {
      return response()->json([
        data => $budgetDetailRelocation
      ], 200);
    } else {
      return response()->json([
        'message' => 'Failed to find budget relocation with budget detail unique id:'.$request->budget_detail_unique_id
      ],400);
    }
  }

  public function add(Request $request) {
    $request->validate([
      'source.unique_id' => 'required',
      'destination' => 'required'
    ]);

    $source = $request->source;
    $destination = $request->destination;

    $sourceBudgetDetail = BudgetDetail::where('unique_id', $source->unique_id)->withRemains()->first();

    if($sourceBudgetDetail->remains < $request->amount){
      return response()->json([
        'message' => 'Failed to relocate fund. Relocated amount is bigger than available amount'
      ],400);
    }

    if($destination->unique_id) {
      $destinationBudgetDetail = BudgetDetail::where('unique_id', $destination->unique_id)->first();
    } else {
      $destinationBudgetDetail = new BudgetDetail();
      $destinationBudgetDetail->unique_id = $request->unique_id_detail;
      $destinationBudgetDetail->head = $request->unique_id_head;
      $destinationBudgetDetail->account = $request->unique_id_account;
      $destinationBudgetDetail->semester = $request->semester;
      $destinationBudgetDetail->code_of_account = $request->code_of_account;
      $destinationBudgetDetail->title = $request->title || 0;
      $destinationBudgetDetail->quantity = $request->quantity || 0;
      $destinationBudgetDetail->price = $request->price || 0;
      $destinationBudgetDetail->term = $request->term || 0;
      $destinationBudgetDetail->ypl = $request->ypl || 0;
      $destinationBudgetDetail->committee = $request->committee || 0;
      $destinationBudgetDetail->intern = $request->intern || 0;
      $destinationBudgetDetail->bos = $request->bos || 0;
      $destinationBudgetDetail->total = $request->total;
      $destinationBudgetDetail->desc = $request->desc || '';
      $destinationBudgetDetail->save();
    }

    $budgetDetailRelocation = new BudgetDetailRelocation();
    $budgetDetailRelocation->source_unique_id = $source->unique_id;
    $budgetDetailRelocation->destination_unique_id = $destinationBudgetDetail->id;
    $budgetDetailRelocation->source_original_amount = $sourceBudgetDetail->total;
    $budgetDetailRelocation->source_revised_amount = $source->total;
    $budgetDetailRelocation->destination_original_amount = $destinationBudgetDetail->total || 0;
    $budgetDetailRelocation->destination_revised_amount = $destination->total;

    $budgetDetailRelocation->save();

    return response()->json([
      'message' => 'Successfully requested relocation of' . ($sourceBudgetDetail->total - $source->total). 'from' .$request->source_unique_id. to .$request->destination_unique_id
    ],200);
  }

  public function updateApproval(Request $request) {
    $budgetDetailRelocation = BudgetDetailRelocation::where('id', $request->id)->get();
    if($budgetDetailRelocation) {
      $sourceBudgetDetail = BudgetDetail::where('budget_detail_unique_id', $budgetDetailRelocation->source_unique_id)->get();
      $destinationBudgetDetail = BudgetDetail::where('budget_detail_unique_id', $budgetDetailRelocation->destination_unique_id)->get();

      $sourceBudgetDetail->update([total => $sourceBudgetDetail->total - $budgetDetailRelocation->amount]);
      $destinationBudgetDetail->update([total => $destinationBudgetDetail->total + $budgetDetailRelocation->amount]);

      $budgetDetailRelocation->update([status => true]);

      return response()->json([
        'message' => 'Successfully relocated' . $request->amount. 'from' .$request->source_unique_id. 'to' .$request->destination_unique_id
      ],200);

    } else {
      return response()->json([
        'message' => 'Failed to update status. Requested resource is not found.'
      ], 400);
    }

  }
}
