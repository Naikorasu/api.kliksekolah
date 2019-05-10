<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BudgetDetailService;

class BudgetDetailController extends Controller
{

  private $budgetDetailService;

  public function __construct(BudgetDetailService $budgetDetailService) {
    $this->budgetDetailService = $budgetDetailService;
  }

  public function list_detail(Request $request, $type=null)
  {
      $results = $this->budgetDetailService->getList($request->filters, $type);
      return response()->json([
          'message' => 'Load Data Detail Success',
          'data' => $results
      ], 200);
  }

  public function list_detail_rapbu(Request $request)
  {
      $request->validate([
          'filters.head' => 'required'
      ]);

      $filters = [
        "head" => $request->head_unique_id
      ];

      $data = $this->budgetDetailService->getRAPBUList($filters);

      return response()->json([
          'message' => 'Load Data Detail All Success',
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

      $delete = BudgetDetail::where('unique_id', $request->detail_unique_id)->delete();

      if ($delete) {
          return response()->json([
              'message' => 'Successfully Delete Budget Row Detail',
              'result' => $delete,
          ], 200);

      } else {

          return response()->json([
              'message' => 'Failed Delete Budget Row Detail',
              'error' => $delete,
          ], 401);
      }

  }
}
