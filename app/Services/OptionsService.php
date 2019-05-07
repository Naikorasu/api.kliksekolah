<?php

namespace App\Services;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\DataNotFoundException;

use App\BudgetDetail;
use App\Budget;

class OptionsService extends BaseService {

  //add code of account for budgetrequest, budget approval
  //Realisasi harus tarik dari budget detail yang sudah ada budget Request

  public function getCodeOfAccounts($filters, $withRealization = false) {
    $conditions = $this->buildFilters($filters);

    try {
      if($withRealization == true) {
        $collection = BudgetDetail::codeOfAccountOptions()->whereHas('budget_request')->get();
      } else {
        $collection = BudgetDetail::codeOfAccountOptions()->where($conditions)->get();
      }
      $options = [];
      foreach($collection as $option) {
        array_push($options, [
          "id" => $option->code_of_account,
          "title" => $option->parameter_code->title
        ]);
      }
      return $options;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
    return $code_of_accounts;
  }

  public function getPeriodes($filters, $withRealization = false) {
    $conditions = $this->buildFilters($filters);

    try {
      $collection = Budget::periodeOptions()->where($conditions)->get();
      
      $options = [];
      foreach($collection as $option) {
        array_push($options, [
          "id" => $option->periode,
          "title" => $option->periode
        ]);
      }
      return $options;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
    return $code_of_accounts;
  }
}
