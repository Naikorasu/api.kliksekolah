<?php

namespace App\Services;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\FundRequestsExceedTotalException;
use App\Exceptions\FundRequestsExceedRemainsException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use App\FundRequests;
use App\BudgetDetails;
use App\Services\BudgetDetailsService;
use App\EntityUnits;

class FundRequestsService extends BaseService {

  private $budgetDetailService;

  public function __construct(BudgetDetailsService $budgetDetailService) {
      $this->budgetDetailService = $budgetDetailService;
  }

  /**
   * fn:validateAmount Validate requested amount against total and remains
   * @param  [decimal] $remains [calculated remaining budget]
   * @param  [decimal] $total   [total allocated budget]
   * @param  [decimal] $amount  [requested amount]
   * @return [null]          [throws exception when fails]
   */
  private function validateAmount($remains, $total, $amount) {
    if(isset($remains) && $remains < $amount) {
      throw new FundRequestsExceedRemainsException($remains, $amount);
    } else if($total < $amount) {
      throw new FundRequestsExceedTotalException($total, $amount);
    }
  }

  public function list($filters=[]) {
    $conditions = $this->buildFilters($filters);

    $fundRequest = FundRequests::with('fundRequestDetails','fundRequestDetails.budgetDetail','budgetDetail')->where($conditions)->orderBy('created_at', 'DESC')->get();

    return $fundRequest;
  }

  public function add($budget_detail_unique_id, $details) {
    $budgetDetail = $this->budgetDetailService->get($budget_detail_unique_id, true);

    $this->validateAmount($budgetDetail->remains, $budgetDetail->total, 0);

    $unit_code = 0;
    $schoolUnit = Auth::user()->schoolUnit;
    $counter = EntityUnits::where('entity_type', 'App\FundRequests');

    if(isset($schoolUnit)) {
      $unit_code = $schoolUnit->unit_code;
      $counter->where('prm_school_units', $schoolUnit->id);
    }

    $fundRequest = new FundRequests();
    $fundRequest->nomor_permohonan =
      str_pad(date('Y'), 3, '0', STR_PAD_LEFT).'.'.
      str_pad(date('m'), 2, '0', STR_PAD_LEFT).'.'.
      str_pad(date('d'), 2, '0', STR_PAD_LEFT).'.'.
      str_pad($unit_code,3,'0',STR_PAD_LEFT).'.'.
      str_pad($counter->count()+1,4,'0',STR_PAD_LEFT);
    $fundRequest->budget_detail_unique_id = $budget_detail_unique_id;
    $fundRequest->amount = 0;
    $fundRequest->user_id = Auth::user()->id;
    $fundRequest->save();
    $fundRequestDetails = [];

    if(is_array($details)) {
      foreach($details as $detail) {
        array_push($fundRequestDetails, [
          'budget_detail_unique_id' => $budgetDetail->id,
          'amount' => $detail['amount'],
          'description' => $detail['description']
        ]);
      }
    } else {
      array_push($fundRequestDetails, [
        'budget_detail_unique_id' => $budgetDetail->id,
        'amount' => $details['amount'],
        'description' => $details['description']
      ]);
    }

    $fundRequest->fundRequestDetails()->createMany($fundRequestDetails);

    $this->updateEntityUnit($fundRequest);
    return $fundRequest->load('fundRequestDetails','fundRequestDetails.budgetDetail','budgetDetail');
  }

  public function edit($id, $budget_detail_unique_id, $details) {

    $budgetDetail = $this->budgetDetailService->get($budget_detail_unique_id, true);

    $this->validateAmount($budgetDetail->remains, $budgetDetail->total, $amount);

    try{
      $fundRequest = FundRequests::status(false, false)->findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }

    $fundRequest->budget_detail_unique_id = $budget_detail_unique_id;
    $fundRequest->amount = $amount;
    $fundRequest->user_id = Auth::user()->id;
    $fundRequest->save();
    $fundRequestDetails = [];

    if(is_array($details)) {
      foreach($details as $detail) {
        array_push($fundRequestDetails, [
          'budget_detail_unique_id' => $budgetDetail->id,
          'amount' => $detail['amount'],
          'description' => $detail['description']
        ]);
      }
    } else {
      array_push($fundRequestDetails, [
        'budget_detail_unique_id' => $budgetDetail->id,
        'amount' => $details['amount'],
        'description' => $details['description']
      ]);
    }

    $fundRequest->fundRequestDetails()->createMany($fundRequestDetails);

    return $fundRequest->load('fundRequestDetails','fundRequestDetails.budgetDetail','budgetDetail');
  }

  public function cancel($id) {
    try {
      $fundRequest = FundRequests::status(false, true)->findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }

    $fundRequest->update(['submitted' => false]);

    return $fundRequest;
  }

  public function delete($id) {
    try {
      $fundRequest = FundRequests::status(false, true)->findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }

    $fundRequest->delete();

    return $fundRequest;
  }


  /**
   * fn:updateStatus update the request status
   * @param  int  $id     the request ID
   * @param  boolean $status the status TRUE|FALSE
   * @return FundRequests          returns the updated model
   */
  public function updateStatus($id, $status=null) {
    if($status == 'approve') {
      $status = true;
    } else {
      $status = false;
    }
    try {
      $fundRequest = FundRequests::status(false,true)->with(['budgetDetail' => function($query) {
        $query->remains();
      }])->findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw DataNotFoundException($exception->getMessage());
    }
    if($status == true) {
      $this->validateAmount($fundRequest->budgetDetail->remains, $fundRequest->budgetDetail->total, $fundRequest->amount);
    }

    $fundRequest->update(['is_approved'=>$status]);

    return $fundRequest;
  }

  public function submit($id) {
    try {
      $fundRequest = FundRequests::status(false,false)->findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }


    $fundRequest->update(['submitted' => true]);

    return $fundRequest;
  }


}
