<?php

namespace App\Services;

use Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\DataNotFoundException;
use App\BudgetDetails;

class BudgetDetailsService extends BaseService {

  /**
  * Get Budgets Detail List
  * @param $filters
  * Available filters:
  *   head: string|head_unique_id
  *   code_of_account: string|code_of_account
  *   semester: integer
  */

  protected $filterable = [
    'unique_id',
    'head',
    'account',
    'semester',
    'title'
  ];

  public function getList($filters=[], $type) {
    $codeOfAccountValue = null;
    $codeOfAccountType = null;
    if(isset($filters)) {
      if(array_key_exists('code_of_account', $filters)) {
        $codeOfAccountValue = $filters['code_of_account'];
        $codeOfAccountType = array_key_exists('type', $filters) ? $filters['type'] : null;
      }
    }
    $conditions = $this->buildFilters($filters);

    $query = BudgetDetails::parameterCode($codeOfAccountValue, $codeOfAccountType)->where($conditions)->orderBy('created_at')->remains();

    if(isset($filters)) {
      if(array_key_exists('periode', $filters)) {
        $query->whereHas('head', function($q) use($filters) {
          if(isset($filters['periode'])) {
            $q->where('periode',$filters['periode']);
          }
        });
      }
    }
    //dd($query->toSql());
    try {
      if($type == 'realization') {
        $results = $query->has('fundRequest')->get();
      } else {
        $results = $query->get();
      }
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
    //return dd(BudgetDetails::parameterCode($codeOfAccountValue, $codeOfAccountType)->where($conditions)->remains()->toSql());
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

    $return = [
      'data' => $data
    ];
    return $data;
  }

  public function getRAPBUList($filters=[]) {
    $codeOfAccountValue = null;
    $codeOfAccountType = null;
    if(isset($filters)) {
      if(array_key_exists('code_of_account', $filters)) {
        $codeOfAccountValue = $filters['code_of_account'];
        $codeOfAccountType = array_key_exists('type', $filters) ? $filters['type'] : null;
      }
    }
    $conditions = $this->buildFilters($filters);

    $results = BudgetDetails::parameterCode($codeOfAccountValue, $codeOfAccountType)->where($conditions)->rAPBU()->orderBy('created_at', 'DESC')->get();

    $incomes = [];
    $expenses = [];

    $totalIncome = 0;
    $totalExpense = 0;
    $totalIncomeYPL = 0;
    $totalExpenseYPL = 0;
    $totalIncomeCommittee = 0;
    $totalExpenseCommittee = 0;
    $totalIncomeIntern = 0;
    $totalExpenseIntern = 0;
    $totalIncomeBos = 0;
    $totalExpenseBos = 0;

    foreach($results as $result) {
      if(Str::startsWith($result->code_of_account,'4')) {
        array_push($incomes,$result);
        $totalIncome += $result->total;
        $totalIncomeYPL += $result->ypl;
        $totalIncomeCommittee += $result->committee;
        $totalIncomeBos += $result->bos;
        $totalIncomeIntern += $result->intern;
      } else {
        array_push($expenses,$result);
        $totalExpense += $result->total;
        $totalExpenseYPL += $result->ypl;
        $totalExpenseCommittee += $result->committee;
        $totalExpenseBos += $result->bos;
        $totalExpenseIntern += $result->intern;
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
        'total_pendapatan_ypl' => $totalIncomeYPL,
        'total_pendapatan_komite' => $totalIncomeCommittee,
        'total_pendapatan_bos' => $totalIncomeBos,
        'total_pendapatan_internal' => $totalIncomeIntern,
        'total_pengeluaran_ypl' => $totalExpenseYPL,
        'total_pengeluaran_komite' => $totalExpenseCommittee,
        'total_pengeluaran_bos' => $totalExpenseBos,
        'total_pengeluaran_internal' => $totalExpenseIntern,
        'status_surplus_defisit' => $status,
        'estimasi_surplus_defisit' => $estimation,
        'saldo' => $balance,
    );

    return $data;
  }

  public function save($data, $head, $account, $accountType, $id=null) {
    if($id) {
      try {
        $budgetDetail = BudgetDetails::findOrFail($id);
        $budgetDetail->update($data);
      } catch (ModelNotFoundException $exception) {
        throw new DataNotFoundException($exception->getMessage());
      }
    } else {

      $budgetDetail = new BudgetDetails($data);
      $budgetDetail->unique_id = $this->generateUniqueId($accountType, $budgetDetail->code_of_account);
      $budgetDetail->head = $head;
      $budgetDetail->account = $account;
      $budgetDetail->save();
    }
    $budgetDetail->load('parameter_code');
    return $budgetDetail;
  }

  public function saveBatch($data = [], $head, $account, $accountType){
    $budgetDetails = [];

    forEach($data as $index => $budgetDetail) {
      $id = array_key_exists('id', $budgetDetail) ? $budgetDetail['id'] : null;
      array_push($budgetDetails, $this->save($budgetDetail, $head, $account, $accountType, $id));
    }

    $result = [
      'head' => $head,
      'account' => $account,
      'account_type' => $accountType,
      'data' => $budgetDetails
    ];

    return $result;
  }

  public function get($unique_id, $withRemains = false) {
    $budgetDetail;

    if($withRemains) {
      $budgetDetail = BudgetDetails::with('parameter_code')->remains()->where('unique_id', $unique_id)->first();
    } else {
      $budgetDetail = BudgetDetails::with('parameter_code')->remains()->where('unique_id', $unique_id)->first();
    }
    if(!isset($budgetDetail)) {
      throw new DataNotFoundException('Budget Detail Not Found');
    }

    return $budgetDetail;

  }

}
