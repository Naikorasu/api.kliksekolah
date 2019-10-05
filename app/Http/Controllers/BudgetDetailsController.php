<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BudgetDetails;
use App\Services\BudgetDetailsService;

class BudgetDetailsController extends Controller
{

  private $budgetDetailService;

  public function __construct(BudgetDetailsService $budgetDetailService) {
    $this->budgetDetailService = $budgetDetailService;
  }

  public function list_detail(Request $request, $type=null)
  {
      $results = $this->budgetDetailService->getList($request->filters, $type);
      $response = [
        'message' => 'Load data detail success'
      ];

      return response()->json(array_merge($response, $results), 200);
  }

  public function list_detail_rapbu(Request $request)
  {
      $request->validate([
          'filters.head' => 'required'
      ]);

      $data = $this->budgetDetailService->getRAPBUList($request->filters);

      return response()->json([
          'message' => 'Load Data Detail All Success',
          'data' => $data,
      ], 200);
  }

  public function save_revisions(Request $request) {
    $data = $this->budgetDetailService->saveRAPBURevision($request);

    return response()->json([
        'message' => 'Successfully saved RAPBU revisions',
        'data' => $data,
    ], 200);
  }

  public function submit_approval(Request $request) {
    $data = $this->budgetDetailService->submitApproval($request);

    return response()->json([
        'message' => 'Successfully saved RAPBU revisions',
        'data' => $data,
    ], 200);
  }

  public function add_detail(Request $request)
  {
      $request->validate([
          'head' => 'required',
          'account' => 'required',
          'account_type' => 'required|integer',
          'data' => 'required'
      ]);

      $data = $this->budgetDetailService->saveBatch($request->data, $request->head, $request->account, $request->account_type);

      return response()->json([
          'message' => 'Succesfully added budget detail',
          'data' => $data
      ],200);
  }

  public function edit_detail(Request $request)
  {
      $request->validate([
          'head' => 'required',
          'account' => 'required',
          'account_type' => 'required|integer',
          'data' => 'required',
      ]);

      $data = $this->budgetDetailService->saveBatch($request->data, $request->head, $request->account, $request->account_type);

      return response()->json([
          'message' => 'Succesfully updated budget detail',
          'data' => $data
      ],200);
  }

  public function delete_detail(Request $request)
  {
      $user = $request->user();
      $user_email = $user->email;

      $request->validate([
          'detail_unique_id' => 'required',
      ]);

      $delete = BudgetDetails::where('unique_id', $request->detail_unique_id)->delete();

      if ($delete) {
          return response()->json([
              'message' => 'Successfully Delete Budgets Row Detail',
              'result' => $delete,
          ], 200);

      } else {

          return response()->json([
              'message' => 'Failed Delete Budgets Row Detail',
              'error' => $delete,
          ], 401);
      }

  }
}
