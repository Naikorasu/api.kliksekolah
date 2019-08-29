<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BudgetDetails;
use App\FundRequests;
use App\Services\FundRequestsService;



class FundRequestsController extends Controller
{
    private $fundRequestService;

    public function __construct(FundRequestsService $fundRequestService) {
        $this->fundRequestService = $fundRequestService;
    }

    public function list(Request $request) {
      $fundRequest = $this->fundRequestService->list($request->filters);

      return response()->json($fundRequest, 200);

    }

    public function get(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $fundRequest = $this->fundRequestService->get($request->id);

      return response()->json([
        'data' => $fundRequest
      ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
      $request->validate([
        'details' => 'array|required'
      ]);

      $data = $this->fundRequestService->save(null, $request);

      return response()->json([
          'message' => 'Successfully Add Fund Request',
          'data' => $data
      ], 201);

    }

    public function edit(Request $request) {
      $request->validate([
          'id' => 'required|integer',
          'details' => 'array|required'
      ]);

      $data = $this->fundRequestService->save($request->id, $request);

      return response()->json([
          'message' => 'Successfully Updated Fund Request',
          'data' => $data
      ], 201);
    }

    public function loadAvailableBudgetDetails(Request $request) {
      $data = $this->fundRequestService->loadAvailableBudgetDetails($request->filters);

      return response()->json($data, 200);
    }

    public function cancel(Request $request) {
      $request->validate([
          'id' => 'required|integer'
      ]);

      $data = $this->fundRequestService->cancel($request->id);

      return response()->json([
        'message' => 'Successfully cancelled the fund request',
        'data' => $data
      ], 200);
    }

    public function delete(Request $request) {
      $request->validate([
          'id' => 'required|integer'
      ]);

      $data = $this->fundRequestService->delete($request->id);

      return response()->json([
        'message' => 'Successfully deleted the fund request',
        'data' => $data
      ], 200);
    }

    public function loadAvailableCoa(Request $request) {
      $data = $this->fundRequestService->loadAvailableCoa($request->head);

      return response()->json([
        'data' => $data
      ], 200);
    }

    public function submit(Request $request) {
      $request->validate([
        'id' => 'required|integer'
      ]);

      $data = $this->fundRequestService->submit($request->id);

      return response()->json([
        'message' => 'Successfully submitted the fund request',
        'data' => $data
      ], 200);
    }

    public function updateStatus(Request $request, $status) {
      $request->validate([
          'id' => 'required|integer'
      ]);

      $data = $this->fundRequestService->updateStatus($request->id, $status);

      return response()->json([
        'message' => 'Successfully submitted the fund request',
        'data' => $data
      ], 200);
    }
}
