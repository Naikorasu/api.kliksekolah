<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BudgetDetail;
use App\FundRequest;



class FundRequestController extends Controller
{
    public function list(Request $request) {
      $fundRequest = FundRequest::where('budget_detail_unique_id', $request->budget_detail_unique_id)->get();
      if($fundRequest) {
        return response()->json([
          'data' => $fundRequest
        ], 200);
      } else {
        return response()->json([
          'message' => 'Failed to find fund request with budget detail unique id:'.$request->budget_detail_unique_id
        ],400);
      }
    }
    public function get(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $fundRequest = FundRequest::with('budgetDetail')->find($request->id);

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
        'budget_detail_unique_id' => 'required',
        'amount' => 'required'
      ]);

      //validate against remains
      $budgetDetail = BudgetDetail::withRemains()->find('unique_id',$request->budget_detail_unique_id);

      if($budgetDetail->remains !== null && $budgetDetail->remains < $request->amount) {
        return response()->json([
          'message' => 'Failed to save fund request. Requested amount is bigger than available amount.'
        ], 400);
      } else if($budgetDetail->total < $request->amount) {
        return response()->json([
          'message' => 'Failed to save fund request. Requested amount is bigger than total.'
        ], 400);
      }
      else {
        $fundRequest = new FundRequest();
        $fundRequest->budget_detail_unique_id = $request->budget_detail_unique_id;
        $fundRequest->amount = $request->amount;
        $fundRequest->save();

        return response()->json([
            'message' => 'Successfully Add Fund Request',
            'data' => $fundRequest,
            'remains' => $budgetDetail->remains
        ], 201);
      }
    }

    public function edit(Request $request) {
      $request->validate([
          'id' => 'required|integer',
          'amount' => 'required'
      ]);

      $fundRequest = FundRequest::where([
        ['id', '=', $request->id],
        ['is_approved', '=', false],
        ['submitted', '=', false]
      ])->first();

      if($this->isValidAmount($fundRequest->budget_detail_unique_id, $request->amount)) {
        $fundRequest->amount = $request->amount;
        $fundRequest->save();

        return response()->json([
            'message' => 'Successfully Updated Fund Request'
        ], 201);
      } else {
        return response()->json([
          'message' => 'Failed to save fund request. Requested amount is bigger than available amount.'
        ], 400);
      }
    }

    public function cancel(Request $request) {
      $request->validate([
          'id' => 'required|integer'
      ]);

      $fundRequest = FundRequest::where([
        ['id', '=', $request->id],
        ['submitted', '=', true],
        ['is_approved', '=', false]
      ])->first();

      $fundRequest->submitted = false;

      $fundRequest->save();

      return response()->json([
        'message' => 'Successfully cancelled the fund request'
      ], 200);
    }

    public function updateStatus(Request $request) {
      $request->validate([
          'id' => 'required|integer',
          'is_approved' => 'required|boolean'
      ]);

      $fundRequest = FundRequest::where([
        ['id', '=', $request->id]
      ])->first();

      if($this->isValidAmount($fundRequest->budget_detail_unique_id, $fundRequest->amount)) {
        $fundRequest->is_approved = $request->is_approved;

        if($fundRequest->save()){
          return response()->json([
            'message' => 'Successfully update approval status'
          ], 200);
        } else {
          return response()->json([
            'message' => 'Failed updating approval status'
          ], 400);
        }
      } else {
        return response()->json([
          'message' => 'Failed updating approval status. Requested amount is bigger than available amount.'
        ], 400);
      }
    }

    private function isValidAmount($budgetDetailUniqueId, $amount) {
      $budgetDetail = BudgetDetail::where('unique_id', $budgetDetailUniqueId)->withRemains()->first();
      if($budgetDetail->total < $amount || $budgetDetail->remains) {
        return false;
      }
      else return true;
    }
}
