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

    $fundRequest = FundRequests::with('budgetDetail')->where($conditions)->orderBy('created_at', 'DESC')->get();
    return $fundRequest;
  }

  public function add($budget_detail_unique_id, $details) {
    $budgetDetail = $this->budgetDetailService->get($budget_detail_unique_id, true);

    $this->validateAmount($budgetDetail->remains, $budgetDetail->total, $amount);

    $fundRequest = new FundRequests();
    $fundRequest->budget_detail_unique_id = $budget_detail_unique_id;
    $fundRequest->amount = $amount;
    $fundRequest->user_id = Auth::user()->id;
    $fundRequest->save();
    $fundRequest->fundRequestDetails()->createMany($details);

    $this->updateEntityUnit($fundRequest);
    return $fundRequest;
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
    $fundRequest->fundRequestDetails()->createMany($details);

    $this->updateEntityUnit($fundRequest);

    return $fundRequest;
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

    $fundRequest->delete()

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
