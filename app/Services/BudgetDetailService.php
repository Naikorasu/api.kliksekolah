<?php

namespace App\Services;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\DataNotFoundException;
use App\BudgetDetail;
use App\Classes\FunctionHelper;

class BudgetDetailService extends BaseService {

  /**
  * Get Budget Detail List
  * @param $filters
  * Available filters:
  *   head: string|head_unique_id
  *   code_of_account: string|code_of_account
  *   semester: integer
  */
  public function getList($filters=[], $type) {
    $codeOfAccountValue = null;
    $codeOfAccountType = null;
    if(array_key_exists('code_of_account', $filters)) {

      $codeOfAccountValue = $filters['code_of_account'];
      $codeOfAccountType = array_key_exists('type', $filters) ? $filters['type'] : null;

      unset($filters['code_of_account']);
      unset($filters['type']);
    }

    $conditions = $this->buildFilters($filters);

    try {
      if($type == 'realization') {
        $results = BudgetDetail::parameterCode($codeOfAccountValue, $codeOfAccountType)->where($conditions)->remains()->has('fundRequest')->get();
      } else {
        $results = BudgetDetail::parameterCode($codeOfAccountValue, $codeOfAccountType)->where($conditions)->remains()->get();
      }
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
    //return dd(BudgetDetail::parameterCode($codeOfAccountValue, $codeOfAccountType)->where($conditions)->remains()->toSql());
    $data = [
      'ganjil' => [],
      'genap' => []
    ];

    foreach($results as $result) {
      if($result->semester == 1) {
        array_push($data['ganjil'], $result);
      } else {
        array_push($data['genap'], $result);
      }
    }

    return $data;
  }

  public function getRAPBUList($filters=[]) {
    $conditions = $this->buildFilters($filters);

    $results = BudgetDetail::where($conditions)->rAPBU()->get();

    $incomes = [];
    $expenses = [];

    $totalIncome = 0;
    $totalExpense = 0;

    foreach($results as $result) {
      if(startsWith($result->code_of_account,'4')) {
        array_push($incomes,$result);
        $totalIncome += $result->total;
      } else {
        array_push($expenses,$result);
        $totalExpense += $result->total;
      }
    }

    $estimation = $totalIncome - $totalExpense;
    $balance = 0;
    $status = 'DEFISIT';

    if($totalIncome >= $totalExpense) {
        $status = 'SURPLUS';
        $balance = $estimation;
    }

    $data = array(
        'pengeluaran' => $expenses,
        'pendapatan' => $incomes,
        'total_pendapatan' => $totalIncome,
        'total_pengeluaran' => $totalExpense,
        'status_surplus_defisit' => $status,
        'estimasi_surplus_defisit' => $estimation,
        'saldo' => $balance,
    );

    return $data;
  }

  public function save($data, $head, $account, $account_type, $id=null) {
    $user = Auth::user();
    $user_email = $user->email;

    if($id) {
      try {
        $budgetDetail = BudgetDetail::findOrFail($id);
        $budgetDetail->update($data);
      } catch (ModelNotFoundException $exception) {
        throw new DataNotFoundException($exception->getMessage());
      }
    } else {
      $fh = New FunctionHelper();

      $budgetDetail = new BudgetDetail($data);
      $budgetDetail->unique_id = $fh::generate_unique_key($user_email . ";" . "DETAIL" . ";" . $account_type . ";" . $budgetDetail->code_of_account . ";");

      $budgetDetail->head = $head;
      $budgetDetail->account = $account;
      $budgetDetail->save();
    }

    return $budgetDetail;
  }
}
