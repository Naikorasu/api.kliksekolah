<?php

namespace App\Services;

use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Budget;

class BudgetService extends BaseService {

  /**
   * Report or log an exception.
   *
   * @param  \Exception  $exception
   * @return void
   */
  public function getList($filters=[]) {

    $conditions = $this->buildFilters($filters);

    try {
      return Budget::where($conditions)->orderBy('created_at', 'DESC')->with('account')->paginate(5);;
    } catch(ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function save($head, $account, $data, $budgetId=null) {
    if($budgetId != null) {
      try {

      } catch(DataNotFoundException $exception) {
        return back()->withError($exeption->getCode(), $exception->getMessage());
      }
    }
  }

  public function edit() {

  }

  public function submit() {

  }

  public function approve() {

  }

  public function reject() {

  }

  public function getPeriodes($filters=[]) {
    $conditions = $this->buildFilters($filters);

    $result = Budget::where($conditions)->select(DB::raw('distinct(periode) as periodes'));

    return $result;
  }
}
