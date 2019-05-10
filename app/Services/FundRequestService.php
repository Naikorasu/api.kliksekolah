<?php

namespace App\Services;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\FundRequestExceedTotalException;
use App\Exceptions\FundRequestExceedRemainsException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use App\FundRequest;
use App\BudgetDetail;
use App\Services\BudgetDetailService;

class FundRequestService extends BaseService {

  private $budgetDetailService;

  public function __construct(BudgetDetailService $budgetDetailService) {
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
      throw new FundRequestExceedRemainsException($remains, $amount);
    } else if($total < $amount) {
      throw new FundRequestExceedTotalException($total, $amount);
    }
  }

  public function add($budget_detail_unique_id, $amount) {
    $budgetDetail = $this->budgetDetailService->get($budget_detail_unique_id, true);

    $this->validateAmount($budgetDetail->remains, $budgetDetail->total, $amount);

    $fundRequest = new FundRequest();
    $fundRequest->budget_detail_unique_id = $budget_detail_unique_id;
    $fundRequest->amount = $amount;
    $fundRequest->user_id = Auth::user()->id;
    $fundRequest->save();

    return $fundRequest;
  }

  public function edit($id, $budget_detail_unique_id, $amount) {

    $budgetDetail = $this->budgetDetailService->get($budget_detail_unique_id, true);

    $this->validateAmount($budgetDetail->remains, $budgetDetail->total, $amount);

    try{
      $fundRequest = FundRequest::status(false, false)->findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }

    $fundRequest->budget_detail_unique_id = $budget_detail_unique_id;
    $fundRequest->amount = $amount;
    $fundRequest->user_id = Auth::user()->id;
    $fundRequest->save();

    return $fundRequest;
  }

  public function cancel($id) {
    try {
      $fundRequest = FundRequest::status(false, true)->findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }

    $fundRequest->update(['submitted' => false]);

    return $fundRequest;
  }

  /**
   * fn:updateStatus update the request status
   * @param  int  $id     the request ID
   * @param  boolean $status the status TRUE|FALSE
   * @return FundRequest          returns the updated model
   */
  public function updateStatus($id, $status=null) {
    if($status == 'approve') {
      $status = true;
    } else {
      $status = false;
    }
    try {
      $fundRequest = FundRequest::status(false,true)->with(['budgetDetail' => function($query) {
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
      $fundRequest = FundRequest::status(false,false)->findOrFail($id);
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }


    $fundRequest->update(['submitted' => true]);

    return $fundRequest;
  }


}
