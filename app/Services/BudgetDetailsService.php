<?php

namespace App\Services;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\DataNotFoundException;
use App\Budgets;
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

    //$conditions = $this->buildFilters($filters);

    $query = BudgetDetails::parameterCode($codeOfAccountValue, $codeOfAccountType)->orderBy('created_at')->remains();

    if(isset($filters)) {
      if(array_key_exists('periode', $filters) || array_key_exists('head', $filters)) {
        $query->whereHas('head', function($q) use($filters) {
          if(isset($filters['periode'])) {
            $q->where('periode',$filters['periode']);
          }
          if(isset($filters['head'])) {
            $q->where('unique_id', '=', $filters['head']);
            $q->orWhere('id', '=', $filters['head']);
          }
        });
      }
      if(isset($filters['listType'])) {
        if($filters['listType'] === 'OUTCOME') {
          $query->whereHas('parameter_code.group.category', function($q) {
            $q->whereIn('class', ['50000','10000']);
          });
        } else if($filters['listType'] === 'INCOME') {
          $query->whereHas('parameter_code.group.category', function($q) {
            $q->whereIn('class', ['40000']);
          });
        }
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
    $user = Auth::user();

    $codeOfAccountValue = null;
    $codeOfAccountType = null;
    if(isset($filters)) {
      if(array_key_exists('code_of_account', $filters)) {
        $codeOfAccountValue = $filters['code_of_account'];
        $codeOfAccountType = array_key_exists('type', $filters) ? $filters['type'] : null;
      }
    }
    $conditions = $this->buildFilters($filters);

    $budget = Budgets::with('workflow')->where('unique_id', $filters['head'])->first();

    if($user->user_groups_id == 2) {
      $results = BudgetDetails::addSelect(DB::raw(('*, IF(revision1 is NULL, total, revision1) as revision1')))->parameterCode($codeOfAccountValue, $codeOfAccountType)->rAPBU()->where($conditions)->orderBy('created_at', 'DESC')->get();
    } else if ($user->user_groups_id == 8) {
      $results = BudgetDetails::addSelect(DB::raw(('*, IF(revision2 is NULL, IF(revision1 is NULL, total, revision1), revision2) as revision2')))->parameterCode($codeOfAccountValue, $codeOfAccountType)->rAPBU()->where($conditions)->orderBy('created_at', 'DESC')->get();
    } else {
      $results = BudgetDetails::parameterCode($codeOfAccountValue, $codeOfAccountType)->rAPBU()->where($conditions)->orderBy('created_at', 'DESC')->get();
    }

    $incomes = [];
    $expenses = [];
    $inventories = [];
    $revisions = [];

    $totalIncome = 0;
    $totalExpense = 0;
    $totalInventories = 0;
    $totalCost = 0;
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
        if(Str::startsWith($result->code_of_account,'13')) {
          array_push($inventories,$result);
          $totalInventories += $result->total;
        } else if(Str::startsWith($result->code_of_account,'5')) {
          array_push($expenses,$result);
          $totalCost += $result->total;
        }
        $totalExpense += $result->total;
        $totalExpenseYPL += $result->ypl;
        $totalExpenseCommittee += $result->committee;
        $totalExpenseBos += $result->bos;
        $totalExpenseIntern += $result->intern;
      }

      $revisions[$result->id] = [
        'revision1' => $result->revision1,
        'revision2' => $result->revision2
      ];
    }

    $estimation = $totalIncome - $totalCost;
    $balance = $totalIncome - ($totalCost + $totalInventories);
    $status = 'UNDEFINED';

    if($estimation > 0) {
        $status = 'SURPLUS';
        $estimation_surplus_defisit = number_format(abs($estimation));
        $balance = number_format(abs($balance));
    }
    else {
        $status = 'DEFISIT';
        $estimation_surplus_defisit = "(".number_format(abs($estimation)).")";
        $balance = "(".number_format(abs($balance)).")";
    }

    $data = array(
        'pengeluaran' => $expenses,
        'pendapatan' => $incomes,
        'inventaris' => $inventories,
        'revisions' => $revisions,
        'total_pendapatan' => $totalIncome,
        'total_pengeluaran' => $totalExpense,
        'total_inventaris' => $totalInventories,
        'total_beban' => $totalCost,
        'total_pendapatan_ypl' => $totalIncomeYPL,
        'total_pendapatan_komite' => $totalIncomeCommittee,
        'total_pendapatan_bos' => $totalIncomeBos,
        'total_pendapatan_internal' => $totalIncomeIntern,
        'total_pengeluaran_ypl' => $totalExpenseYPL,
        'total_pengeluaran_komite' => $totalExpenseCommittee,
        'total_pengeluaran_bos' => $totalExpenseBos,
        'total_pengeluaran_internal' => $totalExpenseIntern,
        'status_surplus_defisit' => $status,
        'estimasi_surplus_defisit' => $estimation_surplus_defisit,
        'saldo' => $balance,
        'workflow' => $budget->workflow,
    );

    return $data;
  }

  public function save($data, $head, $account, $accountType, $id=null) {
    $budget = Budgets::where('unique_id', $head)->first();

    try {
      if(!$this->validateUserGroupForSaving($budget)) {
        throw new ModelNotFoundException('Budget Detail had been submitted.');
      }

      if($id) {
        try {
          $budgetDetail = BudgetDetails::with('head')->findOrFail($id);


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
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }

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

  public function saveRevision($data) {
    $user = Auth::user();
    foreach($data as $budgetDetailId => $item) {
      $budgetDetail = BudgetDetails::find($budgetDetailId);

      //Korektor Perwakilan
      if($user->user_groups_id == 2) {
        $budgetDetail->revision1 = $item['revision1'];
      }
      //Manager Keuangan
      if($user->user_groups_id == 8) {
        $budgetDetail->revision2 = $item['revision2'];
      }

      $budgetDetail->save();
    }
  }

  public function submitApproval($data) {
    $user = Auth::user();
    if($user->user_groups_id == 2 || $user->user_groups_id == 8) {
      $this->saveRevision($data->revisions);
    }

    $budget = Budgets::where('unique_id',$data->head)->first();

    if($user->user_groups_id != 9) {
      $this->updateWorkflow($budget);
    } else {
      $budget->approved = true;
      $budget->save();
      $this->updateWorkflow($budget, true);
    }
  }

  public function rejectApproval($data) {
    $user = Auth::user();

    $budget = Budgets::where('unique_id',$data->head)->first();
    $this->updateWorkflow($budget, false, true);
  }

}
