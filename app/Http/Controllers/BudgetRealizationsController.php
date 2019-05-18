<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BudgetDetails;
use App\BudgetRealizations;
use Auth;
use App\Services\BudgetRealizationsService;

class BudgetRealizationsController extends Controller
{
    protected $budgetRealizationService;

    public function __construct(BudgetRealizationsService $budgetRealizationService) {
        $this->budgetRealizationService = $budgetRealizationService;
    }

    public function list(Request $request) {
      $filters = (isset($request->filters)) ? $request->filters : null;

      $data = $this->budgetRealizationService->list($filters);

      return response()->json($data);
    }

    public function get(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $data = $this->budgetRealizationService->get($request->id);

      return response()->json([
        'data' => $data
      ]);
    }

    public function delete(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $data = $this->budgetRealizationService->delete($request->id);

      return response()->json([
        'message' => 'Successfully deleted budget realization'
      ]);
    }

    public function save(Request $request) {
        $request->validate([
          'budget_detail_unique_id' => 'required',
          'amount' => 'required',
          'file' => 'required|file|mimes:jpeg,jpg,bmp,png,pdf'
        ]);

        $data = $this->budgetRealizationService->save($request->budget_detail_unique_id, $request->amount, $request->file('file') , $request->description, $request->id);

        return response()->json([
          'message' => 'Successfully saved budget realization.',
          'data' => $data
        ]);
    }
}
