<?php

namespace App\Services;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\FundRequestsExceedTotalException;
use App\Exceptions\FundRequestsExceedRemainsException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use App\FundRequests;
use App\BudgetDetails;
use App\Budgets;
use App\CodeAccount;
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

    $fundRequests = FundRequests::select('id', 'created_at', 'nomor_permohonan', 'description')->totalAmount()->where($conditions)->orderBy('created_at', 'DESC')->paginate(5);

    $fundRequests->getCollection()->transform(function($fundRequest) {
      return [
        'id' => $fundRequest['id'],
        'nomor_permohonan' => $fundRequest->nomor_permohonan,
        'created_at' => $fundRequest->created_at,
        'description' => $fundRequest->description,
        'is_approved' => $fundRequest->is_approved,
        'amount' => $fundRequest->amount,
        'budget_detail' => [
          'description' => $fundRequest->description,
          'nomor_permohonan' => $fundRequest->nomor_permohonan,
          'created_at' => $fundRequest->created_at
        ]
      ];
    });

    return $fundRequests;
  }

  public function save($id = null, $data) {
    $unit_code = 0;
    $schoolUnit = Auth::user()->schoolUnit;
    $counter = EntityUnits::where('entity_type', 'App\FundRequests');

    if(isset($id)) {
      try{
        $fundRequest = FundRequests::status(false, false)->findOrFail($id);
        $fundRequest->fundRequestDetails()->forceDelete();
      } catch (ModelNotFoundException $exception) {
        throw new DataNotFoundException($exception->getMessage());
      }
    } else {
      $fundRequest = new FundRequests();
      $fundRequest->nomor_permohonan =
        str_pad(date('Y'), 3, '0', STR_PAD_LEFT).'.'.
        str_pad(date('m'), 2, '0', STR_PAD_LEFT).'.'.
        str_pad(date('d'), 2, '0', STR_PAD_LEFT).'.'.
        str_pad($unit_code,3,'0',STR_PAD_LEFT).'.'.
        str_pad($counter->count()+1,4,'0',STR_PAD_LEFT);
    }

    $fundRequest->budget_detail_unique_id = '';
    $fundRequest->user_id = Auth::user()->id;
    $fundRequest->description = $data->description;
    $fundRequestDetails = [];
    $totalAmount = 0;

    if(isset($data->details)) {
      foreach($data->details as $detail) {
        $budgetDetail = $this->budgetDetailService->get($detail->unique_id, true);
        $this->validateAmount($budgetDetail->remains, $budgetDetail->amount, 0);
        $totalAmount = $totalAmount + $budgetDetail->amount;
        array_push($fundRequestDetails, [
          'budget_detail_unique_id' => $budgetDetail->id,
          'amount' => $detail['amount'],
          'description' => $detail['description']
        ]);
      }
    }

    $fundRequest->save();
    $fundRequest->fundRequestDetails()->createMany($fundRequestDetails);

    // if(isset($schoolUnit)) {
    //   $unit_code = $schoolUnit->unit_code;
    //   $counter->where('prm_school_units', $schoolUnit->id);
    // }
    //
    // $this->updateEntityUnit($fundRequest);
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

  public function loadAvailableCoa($head) {
    $budget = Budgets::select('unique_id')->find($head);

    $coa = CodeAccount::whereHas('budgetDetail', function($q) use($budget) {
      $q->where('head', $budget->unique_id);
    })->get();

    return $coa;
  }

  public function loadAvailableBudgetDetails($filters) {
    $budgetDetails = BudgetDetails::remains()->with('head','parameter_code')->orderBy('code_of_account');
    if(isset($filters)) {
      if(isset($filters['periode']) || isset($filters['head'])) {
        $budgetDetails->whereHas('head', function($q) use($filters) {
          if(isset($filters['periode'])) {
            $q->where('periode', $filters['periode']);
          }
          if(isset($filters['head'])) {
            $q->where('id', $filters['head']);
          }
        });
      }

      if(isset($filters['code'])) {
        if(isset($filters['type'])) {
          if($filters['type'] == 'account') {
            $budgetDetails->where('code_of_account', $filters['code']);
          } else if($filters['type'] == 'class') {
            $budgetDetails->whereHas('parameter_code.group.category.class', function($q) use($filters) {
              $q->where('code', $filters['code']);
            });
          } else if($filters['type'] == 'category') {
            $budgetDetails->whereHas('parameter_code.group.category', function($q) use($filters) {
              $q->where('code', $filters['code']);
            });
          } else if($filters->type == 'group') {
            $budgetDetails->whereHas('parameter_code.group', function($q) use($filters) {
              $q->where('code', $filters['code']);
            });
          }
        }
      }
    }

    return [
      'data' => $budgetDetails->first()
    ];
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
