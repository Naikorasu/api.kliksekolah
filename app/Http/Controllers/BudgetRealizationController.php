<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BudgetDetail;
use App\BudgetRealization;
use Auth;

class BudgetRealizationController extends Controller
{
    public function list(Request $request) {
      $budgetRealizations = BudgetRealization::paginate(5);
      return response()-json([
        'data' => $budgetRealization
      ]);
    }

    public function get(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $budgetRealization = BudgetRealization::find($request->id);
      $budgetRealization->filename = '/storage/files/budget_realization_'.$budgetRealization->id.'_'.$budgetRealization->filename;
      return response()->json([
        'data' => $budgetRealization
      ]);
    }

    public function add(Request $request) {
        $request->validate([
          'budget_detail_unique_id' => 'required',
          'amount' => 'required',
          'file' => 'required|file|mimes:jpeg,jpg,bmp,png,pdf'
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        $budgetRealization = new BudgetRealization();
        $budgetRealization->budget_detail_unique_id = $request->budget_detail_unique_id;
        $budgetRealization->filename = $fileName;
        $budgetRealization->amount = $request->amount;
        $budgetRealization->description = $request->description;
        $budgetRealization->user_id = Auth::user()->id;
        $budgetRealization->save();

        $file->storeAs('public/files', 'budget_realization_'.$budgetRealization->id.'_'.$fileName);

        return response()->json([
          'message' => 'Successfully saved budget realization.',
          'data' => $budgetRealization
        ]);
    }
}
