<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NonBudgets;
use App\Services\NonBudgetsService;

class NonBudgetsController extends Controller
{

    private $nonBudgetService;

    public function __construct(NonBudgetsService $nonBudgetService) {
        $this->nonBudgetService = $nonBudgetService;
    }

    public function list(Request $request) {
      $filters = $request->filters;

      $data = $this->nonBudgetService->list($filters);
      return response()->json($data,200);
    }

    public function get(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $data = $this->nonBudgetService->get($request->id);

      return response()->json($data,200);
    }

    public function add(Request $request) {
      $request->validate([
        'code_of_account' => 'required',
        'amount' => 'required',
        'activity' => 'required'
      ]);

      $data = $this->nonBudgetService->save($request->all());
      return response()->json([
        'message' => 'Successfully saved non budget request.',
        'data' => $data,
      ],200);
    }

    public function edit(Request $request) {
      $request->validate([
        'id' => 'required',
        'code_of_account' => 'required',
        'amount' => 'required',
        'activity' => 'required'
      ]);

      $data = $this->nonBudgetService->save($request->all());
      return response()->json([
        'message' => 'Successfully saved non budget request.',
        'data' => $data,
      ],200);
    }

    public function submit(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $data = $this->nonBudgetService->submit($request->id);

      return response()->json([
        'message' => 'The request has been submitted.',
        'data' => $data
      ],200);
    }

    public function cancel(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $data = $this->nonBudgetService->cancel($request->id);

      return response()->json([
        'message' => 'The request has been cancelled.',
        'data' => $data
      ],200);
    }

    public function delete(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $data = $this->nonBudgetService->delete($request->id);

      return response()->json([
        'message' => 'The request has been deleted.',
        'data' => $data
      ],200);
    }

    public function updateStatus(Request $request, $type=null) {
      $request->validate([
        'id' => 'required'
      ]);

      $data = $this->nonBudgetService->updateStatus($request->id, $type);

      return response()->json([
        'message' => 'Succesfully saved the request.',
        'data' => $data
      ],200);
    }
}
