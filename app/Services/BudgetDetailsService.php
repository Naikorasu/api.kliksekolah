<?php

namespace App\Services;

use Auth;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\DataNotFoundException;
use App\BudgetDetailDrafts;
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
    if(isset($filters['head'])) {
      $budget = Budgets::select('approved')->where('unique_id', $filters['head'])->first();
    }

    if($budget->approved == true) {
      $query = BudgetDetails::parameterCode($codeOfAccountValue, $codeOfAccountType)->orderBy('created_at')->remains();
    } else {
      $query = BudgetDetailDrafts::parameterCode($codeOfAccountValue, $codeOfAccountType)->orderBy('created_at');
    }

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

    if($budget->approved == true) {
      $results = BudgetDetails::parameterCode($codeOfAccountValue, $codeOfAccountType)
        ->rAPBU()
        ->where($conditions)
        ->with('budgetDetailDraft')
        ->orderBy('created_at', 'DESC')
        ->get();
    } else {
      $results = BudgetDetailDrafts::parameterCode($codeOfAccountValue, $codeOfAccountType)->rAPBU()->where($conditions)->orderBy('created_at', 'DESC')->get();
    }

    $ganjil = [
      'pendapatan' => [],
      'pengeluaran' => [],
      'inventaris' => [],
      'total_pendapatan' => 0,
      'total_pengeluaran' => 0,
      'total_inventaris' => 0,
      'total_beban' => 0,
      'total_pendapatan_ypl' => 0,
      'total_pengeluaran_ypl' => 0,
      'total_inventaris_ypl' => 0,
      'total_beban_ypl' => 0,
      'total_pendapatan_komite' => 0,
      'total_pengeluaran_komite' => 0,
      'total_inventaris_komite' => 0,
      'total_beban_komite' => 0,
      'total_pendapatan_intern' => 0,
      'total_pengeluaran_intern' => 0,
      'total_inventaris_intern' => 0,
      'total_beban_intern' => 0,
      'total_pendapatan_bos' => 0,
      'total_pengeluaran_bos' => 0,
      'total_inventaris_bos' => 0,
      'total_beban_bos' => 0,
      'total_estimasi_ypl' => 0,
      'total_estimasi_komite' => 0,
      'total_estimasi_bos' => 0,
      'total_estimasi_intern' => 0
    ];

    $genap = [
      'pendapatan' => [],
      'pengeluaran' => [],
      'inventaris' => [],
      'total_pendapatan' => 0,
      'total_pengeluaran' => 0,
      'total_inventaris' => 0,
      'total_beban' => 0,
      'total_pendapatan_ypl' => 0,
      'total_pengeluaran_ypl' => 0,
      'total_inventaris_ypl' => 0,
      'total_beban_ypl' => 0,
      'total_pendapatan_komite' => 0,
      'total_pengeluaran_komite' => 0,
      'total_inventaris_komite' => 0,
      'total_beban_komite' => 0,
      'total_pendapatan_intern' => 0,
      'total_pengeluaran_intern' => 0,
      'total_inventaris_intern' => 0,
      'total_beban_intern' => 0,
      'total_pendapatan_bos' => 0,
      'total_pengeluaran_bos' => 0,
      'total_inventaris_bos' => 0,
      'total_beban_bos' => 0,
      'total_estimasi_ypl' => 0,
      'total_estimasi_komite' => 0,
      'total_estimasi_bos' => 0,
      'total_estimasi_intern' => 0
    ];

    $recommendations = [
      'ypl' => null,
      'intern' => null,
      'committee' => null,
      'bos' => null
    ];

    foreach($results as $result) {
      if(Str::startsWith($result->code_of_account,'4')) {
        if($result->semester == 1) {
          array_push($ganjil['pendapatan'],$result);
          $ganjil['total_pendapatan'] += $result->total;
          $ganjil['total_pendapatan_ypl'] += $result->ypl;
          $ganjil['total_pendapatan_komite'] += $result->committee;
          $ganjil['total_pendapatan_bos'] += $result->bos;
          $ganjil['total_pendapatan_intern'] += $result->intern;
        } else {
          array_push($genap['pendapatan'],$result);
          $genap['total_pendapatan'] += $result->total;
          $genap['total_pendapatan_ypl'] += $result->ypl;
          $genap['total_pendapatan_komite'] += $result->committee;
          $genap['total_pendapatan_bos'] += $result->bos;
          $genap['total_pendapatan_intern'] += $result->intern;
        }
      } else {
        if(Str::startsWith($result->code_of_account,'13')) {
          if($result->semester == 1) {
            array_push($ganjil['inventaris'],$result);
            $ganjil['total_inventaris'] += $result->total;
            $ganjil['total_inventaris_ypl'] += $result->ypl;
            $ganjil['total_inventaris_komite'] += $result->committee;
            $ganjil['total_inventaris_bos'] += $result->bos;
            $ganjil['total_inventaris_intern'] += $result->intern;
          } else {
            array_push($genap['inventaris'],$result);
            $genap['total_inventaris'] += $result->total;
            $genap['total_inventaris_ypl'] += $result->ypl;
            $genap['total_inventaris_komite'] += $result->committee;
            $genap['total_inventaris_bos'] += $result->bos;
            $genap['total_inventaris_intern'] += $result->intern;
          }
        } else if(Str::startsWith($result->code_of_account,'5')) {
          if($result->semester == 1) {
            array_push($ganjil['pengeluaran'],$result);
            $ganjil['total_pengeluaran'] += $result->total;
            $ganjil['total_pengeluaran_ypl'] += $result->ypl;
            $ganjil['total_pengeluaran_komite'] += $result->committee;
            $ganjil['total_pengeluaran_bos'] += $result->bos;
            $ganjil['total_pengeluaran_intern'] += $result->intern;
          } else {
            array_push($genap['pengeluaran'],$result);
            $genap['total_pengeluaran'] += $result->total;
            $genap['total_pengeluaran_ypl'] += $result->ypl;
            $genap['total_pengeluaran_komite'] += $result->committee;
            $genap['total_pengeluaran_bos'] += $result->bos;
            $genap['total_pengeluaran_intern'] += $result->intern;
          }
        }
        if($result->semester == 1) {
          $ganjil['total_beban'] += $result->total;
          $ganjil['total_beban_ypl'] += $result->ypl;
          $ganjil['total_beban_komite'] += $result->committee;
          $ganjil['total_beban_bos'] += $result->bos;
          $ganjil['total_beban_intern'] += $result->intern;
        } else {
          $genap['total_beban'] += $result->total;
          $genap['total_beban_ypl'] += $result->ypl;
          $genap['total_beban_komite'] += $result->committee;
          $genap['total_beban_bos'] += $result->bos;
          $genap['total_beban_intern'] += $result->intern;
        }
      }

      if(isset($result->recommendation_ypl)) {
        $recommendations['ypl'][$result->id] = $result->recommendation_ypl;
      }
      if(isset($result->recommendation_committee)) {
        $recommendations['committee'][$result->id] = $result->recommendation_committee;
      }
      if(isset($result->recommendation_intern)) {
        $recommendations['intern'][$result->id] = $result->recommendation_intern;
      }
      if(isset($result->recommendation_bos)) {
        $recommendations['bos'][$result->id] = $result->recommendation_bos;
      }
    }

    $ganjil['total_estimasi'] = $ganjil['total_pendapatan'] - $ganjil['total_pengeluaran'];
    $ganjil['total_estimasi_ypl'] = $ganjil['total_pendapatan_ypl'] - $ganjil['total_pengeluaran_ypl'];
    $ganjil['total_estimasi_komite'] = $ganjil['total_pendapatan_komite'] - $ganjil['total_pengeluaran_komite'];
    $ganjil['total_estimasi_bos'] = $ganjil['total_pendapatan_bos'] - $ganjil['total_pengeluaran_bos'];
    $ganjil['total_estimasi_intern'] = $ganjil['total_pendapatan_intern'] - $ganjil['total_pengeluaran_intern'];
    $ganjil['total_saldo'] = $ganjil['total_pendapatan'] - $ganjil['total_beban'];
    $ganjil['total_saldo_ypl'] = $ganjil['total_pendapatan_ypl'] - $ganjil['total_beban_ypl'];
    $ganjil['total_saldo_komite'] = $ganjil['total_pendapatan_komite'] - $ganjil['total_beban_komite'];
    $ganjil['total_saldo_bos'] = $ganjil['total_pendapatan_bos'] - $ganjil['total_beban_bos'];
    $ganjil['total_saldo_intern'] = $ganjil['total_pendapatan_intern'] - $ganjil['total_beban_intern'];
    $ganjil['status'] = ($ganjil['total_estimasi'] > 0) ? 'SURPLUS' : 'DEFISIT';

    $genap['total_estimasi'] = $genap['total_pendapatan'] - $genap['total_pengeluaran'];
    $genap['total_estimasi_ypl'] = $genap['total_pendapatan_ypl'] - $genap['total_pengeluaran_ypl'];
    $genap['total_estimasi_komite'] = $genap['total_pendapatan_komite'] - $genap['total_pengeluaran_komite'];
    $genap['total_estimasi_bos'] = $genap['total_pendapatan_bos'] - $genap['total_pengeluaran_bos'];
    $genap['total_estimasi_intern'] = $genap['total_pendapatan_intern'] - $genap['total_pengeluaran_intern'];
    $genap['total_saldo'] = $genap['total_pendapatan'] - $genap['total_beban'];
    $genap['total_saldo_ypl'] = $genap['total_pendapatan_ypl'] - $genap['total_beban_ypl'];
    $genap['total_saldo_komite'] = $genap['total_pendapatan_komite'] - $genap['total_beban_komite'];
    $genap['total_saldo_bos'] = $genap['total_pendapatan_bos'] - $genap['total_beban_bos'];
    $genap['total_saldo_intern'] = $genap['total_pendapatan_intern'] - $genap['total_beban_intern'];
    $genap['status'] = ($genap['total_estimasi'] > 0) ? 'SURPLUS' : 'DEFISIT';

    $data = array(
        'ganjil' => $ganjil,
        'genap' => $genap,
        'recommendations' => $recommendations,
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
          $budgetDetail = BudgetDetailDrafts::with('head')->findOrFail($id);
          $budgetDetail->update($data);
        } catch (ModelNotFoundException $exception) {
          throw new DataNotFoundException($exception->getMessage());
        }
      } else {
        $budgetDetail = new BudgetDetailDrafts($data);
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
      $budgetDetail = BudgetDetailDrafts::with('parameter_code')->remains()->where('unique_id', $unique_id)->first();
    } else {
      $budgetDetail = BudgetDetailDrafts::with('parameter_code')->remains()->where('unique_id', $unique_id)->first();
    }
    if(!isset($budgetDetail)) {
      throw new DataNotFoundException('Budget Detail Not Found');
    }

    return $budgetDetail;
  }

  public function saveRecommendation($data) {
    $user = Auth::user();
    //dd($data);
    foreach($data as $pos => $ids) {
      if(isset($data[$pos])) {
        foreach($ids as $budgetDetailId => $value) {
          $budgetDetail = BudgetDetails::find($budgetDetailId);
          if($user->user_groups_id == 2 || $user->user_groups_id == 8) {
            $budgetDetail['recommendation_' . $pos] = $value;
            $budgetDetail->save();
          }
        }
      }
    }
  }

  public function submitApproval($data) {
    $user = Auth::user();
    if($user->user_groups_id == 2 || $user->user_groups_id == 8) {
      $this->saveRecommendation($data->recommendations);
    }

    $budget = Budgets::where('unique_id',$data->head)->first();

    if($user->user_groups_id != 9) {
      $this->updateWorkflow($budget);
    } else {
      $budget->approved = true;
      $budget->save();
      if(isset($data->selectedBudgetDetails)) {
        foreach($data->selectedBudgetDetails as $index => $id) {
          $draft = BudgetDetailDrafts::find($id)->toArray();
          BudgetDetails::create(
            $draft
          );
        }
      }
      $this->updateWorkflow($budget, true);
    }
  }

  public function rejectApproval($data) {
    $user = Auth::user();

    if($user->user_groups_id == 2 || $user->user_groups_id == 8) {
      $this->saveRecommendation($data->recommendations);
    }

    $budget = Budgets::where('unique_id',$data->head)->first();
    $this->updateWorkflow($budget, false, true, $data->remarks);
  }

  public function parseFile($file) {
    try {

    } catch (Exception $exception) {

    }
  }
}
