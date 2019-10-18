<?php

namespace App\Services;

use Auth;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\DataNotFoundException;
use App\BudgetDetailDraftRevisions;
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
        ->with('budgetDetailDraft', 'recommendations')
        ->orderBy('code_of_account', 'ASC')
        ->get();
    } else {
      $results = BudgetDetailDrafts::parameterCode($codeOfAccountValue, $codeOfAccountType)
        ->rAPBU()
        ->where($conditions)
        ->with('recommendations')
        ->orderBy('created_at', 'DESC')
        ->get();
    }

    $ganjil = [
      'pendapatan' => [],
      'pengeluaran' => []
    ];

    $genap = [
      'pendapatan' => [],
      'pengeluaran' => []
    ];

    $inventaris = [];
    $total_pendapatan= 0;
    $total_pengeluaran= 0;
    $total_inventaris= 0;
    $total_pendapatan_ypl= 0;
    $total_pengeluaran_ypl= 0;
    $total_inventaris_ypl= 0;
    $total_pendapatan_komite= 0;
    $total_pengeluaran_komite= 0;
    $total_inventaris_komite= 0;
    $total_pendapatan_intern= 0;
    $total_pengeluaran_intern= 0;
    $total_inventaris_intern= 0;
    $total_pendapatan_bos= 0;
    $total_pengeluaran_bos= 0;
    $total_inventaris_bos= 0;
    $total_estimasi_ypl= 0;
    $total_estimasi_komite= 0;
    $total_estimasi_bos= 0;
    $total_estimasi_intern= 0;
    $total_saldo = 0;
    $total_saldo_ypl = 0;
    $total_saldo_komite = 0;
    $total_saldo_intern = 0;
    $total_saldo_bos = 0;

    $recommendations = [];

    foreach($results as $result) {
      if(Str::startsWith($result->code_of_account,'4')) {
        if($result->semester == 1) {
          array_push($ganjil['pendapatan'],$result);
        } else {
          array_push($genap['pendapatan'],$result);
        }
        $total_pendapatan += $result->total;
        $total_pendapatan_ypl += $result->ypl;
        $total_pendapatan_komite += $result->committee;
        $total_pendapatan_bos += $result->bos;
        $total_pendapatan_intern += $result->intern;
      } else {
        if(Str::startsWith($result->code_of_account,'13')) {
          array_push($inventaris,$result);
          $total_inventaris += $result->total;
          $total_inventaris_ypl += $result->ypl;
          $total_inventaris_komite += $result->committee;
          $total_inventaris_bos += $result->bos;
          $total_inventaris_intern += $result->intern;
        } else if(Str::startsWith($result->code_of_account,'5')) {
          if($result->semester == 1) {
            array_push($ganjil['pengeluaran'],$result);
          } else {
            array_push($genap['pengeluaran'],$result);
          }
          $total_pengeluaran += $result->total;
          $total_pengeluaran_ypl += $result->ypl;
          $total_pengeluaran_komite += $result->committee;
          $total_pengeluaran_bos += $result->bos;
          $total_pengeluaran_intern += $result->intern;
        }
      }

      if(isset($result->recommendations)) {
        foreach($result->recommendations as $recommendation) {
          if(!isset($recommendations[$recommendation->user_groups_id])) {
            $recommendations[$recommendation->user_groups_id] = [
              'ypl' => null,
              'committee' => null,
              'intern' => null,
              'bos' => null,
            ];
          }
          $recommendations[$recommendation->user_groups_id][$recommendation->field][$recommendation->budget_detail_drafts_id] = $recommendation->value;
        }
      }
    }

    $total_estimasi = $total_pendapatan - $total_pengeluaran;
    $total_estimasi_ypl = $total_pendapatan_ypl - $total_pengeluaran_ypl;
    $total_estimasi_komite = $total_pendapatan_komite - $total_pengeluaran_komite;
    $total_estimasi_bos = $total_pendapatan_bos - $total_pengeluaran_bos;
    $total_estimasi_intern = $total_pendapatan_intern - $total_pengeluaran_intern;
    $total_saldo = $total_pendapatan - $total_pengeluaran - $total_inventaris;
    $total_saldo_ypl = $total_pendapatan_ypl - $total_pengeluaran_ypl - $total_inventaris_ypl;
    $total_saldo_komite = $total_pendapatan_komite - $total_pengeluaran_komite - $total_inventaris_komite;
    $total_saldo_bos = $total_pendapatan_bos - $total_pengeluaran_bos - $total_inventaris_bos;
    $total_saldo_intern = $total_pendapatan_intern - $total_pengeluaran_intern - $total_inventaris_intern;
    $status = ($total_estimasi > 0) ? 'SURPLUS' : 'DEFISIT';

    $data = array(
        'ganjil' => $ganjil,
        'genap' => $genap,
        'recommendations' => $recommendations,
        'workflow' => $budget->workflow,
        'inventaris' => $inventaris,
        'total_pendapatan' => $total_pendapatan,
        'total_pengeluaran' => $total_pengeluaran,
        'total_inventaris' => $total_inventaris,
        'total_pendapatan_ypl' => $total_inventaris_ypl,
        'total_pengeluaran_ypl' => $total_pengeluaran_ypl,
        'total_inventaris_ypl' => $total_inventaris_ypl,
        'total_pendapatan_komite' => $total_pendapatan_komite,
        'total_pengeluaran_komite' => $total_pengeluaran_komite,
        'total_inventaris_komite' => $total_inventaris_komite,
        'total_pendapatan_intern' => $total_pendapatan_intern,
        'total_pengeluaran_intern' => $total_pengeluaran_intern,
        'total_inventaris_intern' => $total_inventaris_intern,
        'total_pendapatan_bos' => $total_pendapatan_bos,
        'total_pengeluaran_bos' => $total_pengeluaran_bos,
        'total_inventaris_bos' => $total_inventaris_bos,
        'total_estimasi_ypl' => $total_estimasi_ypl,
        'total_estimasi_komite' => $total_estimasi_komite,
        'total_estimasi_bos' => $total_estimasi_bos,
        'total_estimasi_intern' => $total_estimasi_intern,
        'total_saldo' => $total_saldo,
        'total_saldo_ypl' => $total_saldo_ypl,
        'total_saldo_komite' => $total_saldo_komite,
        'total_saldo_intern' => $total_saldo_intern,
        'total_saldo_bos' => $total_saldo_bos
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
    foreach($data as $userGroupsId => $pos) {
      if(isset($pos)) {
        foreach($pos as $key => $budgetDetailIds) {
          if(isset($budgetDetailIds)) {
            foreach($budgetDetailIds as $id => $value) {
              if(isset($value) && (float) $value > 0) {
                $revisions = BudgetDetailDraftRevisions::updateOrCreate(
                [
                  'budget_detail_drafts_id' => $id,
                  'user_groups_id' => $userGroupsId,
                  'field' => $key,
                ], [
                  'budget_detail_drafts_id' => $id,
                  'field' => $key,
                  'value' => (float) $value,
                  'user_groups_id' => $userGroupsId
                ]);
              }
            }
          }
        }
      }
    }
  }

  public function submitApproval($data) {
    $user = Auth::user();
    if($user->user_groups_id == 10 || $user->user_groups_id == 8 || $user->user_groups_id == 9) {
      $this->saveRecommendation($data->recommendations);
    }

    $budget = Budgets::where('unique_id',$data->head)->first();

    if($user->user_groups_id != 9) {
      $this->updateWorkflow($budget);
    } else {
      $budget->approved = true;
      $budget->save();
      if(isset($data->recommendations[$user->user_groups_id])) {
        $recommendations = $data->recommendations[$user->user_groups_id];
        foreach($recommendations as $pos => $ids) {
          if(isset($ids)) {
            foreach($ids as $id => $value) {
              $draft = BudgetDetailDrafts::find($id)->toArray();
              $draft[$pos] = $value;
              BudgetDetails::updateOrCreate([
                'unique_id' => $draft['unique_id']
              ], $draft);
            }
          }
        }
      }
      // if(isset($data->selectedBudgetDetails)) {
      //   foreach($data->selectedBudgetDetails as $index => $id) {
      //     $draft = BudgetDetailDrafts::find($id)->toArray();
      //     BudgetDetails::create(
      //       $draft
      //     );
      //   }
      // }
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
