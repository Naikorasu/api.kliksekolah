<?php

namespace App\Services;

use Auth;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
      $budget = Budgets::with('workflow')->where('unique_id', $filters['head'])->first();
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

    if(isset($budget->workflow)) {
      $data['lastWorkflow'] = $budget->workflow->values()->last();
    }

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
    $user->load('userGroup');
    $userGroup = $user->userGroup;

    $codeOfAccountValue = null;
    $codeOfAccountType = null;
    if(isset($filters)) {
      if(array_key_exists('code_of_account', $filters)) {
        $codeOfAccountValue = $filters['code_of_account'];
        $codeOfAccountType = array_key_exists('type', $filters) ? $filters['type'] : null;
      }
    }
    $conditions = $this->buildFilters($filters);

    $budget = Budgets::with([
      'workflow' => function($q) {
        $q->orderBy('updated_at', 'ASC');
      }
    ])->where('unique_id', $filters['head'])->first();
    if($budget->approved == true) {
      $results = BudgetDetails::parameterCode($codeOfAccountValue, $codeOfAccountType)
        ->rAPBU()
        ->where($conditions)
        ->with('budgetDetailDraft', 'recommendations')
        ->whereHas('budgetDetailDraft')
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
    $total_estimasi = 0;
    $total_estimasi_ypl= 0;
    $total_estimasi_komite= 0;
    $total_estimasi_bos= 0;
    $total_estimasi_intern= 0;
    $total_saldo = 0;
    $total_saldo_ypl = 0;
    $total_saldo_komite = 0;
    $total_saldo_intern = 0;
    $total_saldo_bos = 0;

    $total_rapbu_pendapatan= 0;
    $total_rapbu_pengeluaran= 0;
    $total_rapbu_inventaris= 0;
    $total_rapbu_pendapatan_ypl= 0;
    $total_rapbu_pengeluaran_ypl= 0;
    $total_rapbu_inventaris_ypl= 0;
    $total_rapbu_pendapatan_komite= 0;
    $total_rapbu_pengeluaran_komite= 0;
    $total_rapbu_inventaris_komite= 0;
    $total_rapbu_pendapatan_intern= 0;
    $total_rapbu_pengeluaran_intern= 0;
    $total_rapbu_inventaris_intern= 0;
    $total_rapbu_pendapatan_bos= 0;
    $total_rapbu_pengeluaran_bos= 0;
    $total_rapbu_inventaris_bos= 0;
    $total_rapbu_estimasi_ypl= 0;
    $total_rapbu_estimasi_komite= 0;
    $total_rapbu_estimasi_bos= 0;
    $total_rapbu_estimasi_intern= 0;
    $total_rapbu_saldo = 0;
    $total_rapbu_saldo_ypl = 0;
    $total_rapbu_saldo_komite = 0;
    $total_rapbu_saldo_intern = 0;
    $total_rapbu_saldo_bos = 0;

    $total_pendapatan_rekomendasi= 0;
    $total_pengeluaran_rekomendasi= 0;
    $total_inventaris_rekomendasi= 0;
    $total_pendapatan_rekomendasi_ypl= 0;
    $total_pengeluaran_rekomendasi_ypl= 0;
    $total_inventaris_rekomendasi_ypl= 0;
    $total_pendapatan_rekomendasi_komite= 0;
    $total_pengeluaran_rekomendasi_komite= 0;
    $total_inventaris_rekomendasi_komite= 0;
    $total_pendapatan_rekomendasi_intern= 0;
    $total_pengeluaran_rekomendasi_intern= 0;
    $total_inventaris_rekomendasi_intern= 0;
    $total_pendapatan_rekomendasi_bos= 0;
    $total_pengeluaran_rekomendasi_bos= 0;
    $total_inventaris_rekomendasi_bos= 0;
    $total_estimasi_rekomendasi_ypl= 0;
    $total_estimasi_rekomendasi_komite= 0;
    $total_estimasi_rekomendasi_bos= 0;
    $total_estimasi_rekomendasi_intern= 0;
    $total_saldo_rekomendasi = 0;
    $total_saldo_rekomendasi_ypl = 0;
    $total_saldo_rekomendasi_komite = 0;
    $total_saldo_rekomendasi_intern = 0;
    $total_saldo_rekomendasi_bos = 0;
    $total_pendapatan_apbu= 0;
    $total_pengeluaran_apbu= 0;
    $total_inventaris_apbu= 0;
    $total_pendapatan_apbu_ypl= 0;
    $total_pengeluaran_apbu_ypl= 0;
    $total_inventaris_apbu_ypl= 0;
    $total_pendapatan_apbu_komite= 0;
    $total_pengeluaran_apbu_komite= 0;
    $total_inventaris_apbu_komite= 0;
    $total_pendapatan_apbu_intern= 0;
    $total_pengeluaran_apbu_intern= 0;
    $total_inventaris_apbu_intern= 0;
    $total_pendapatan_apbu_bos= 0;
    $total_pengeluaran_apbu_bos= 0;
    $total_inventaris_apbu_bos= 0;
    $total_estimasi_apbu_ypl= 0;
    $total_estimasi_apbu_komite= 0;
    $total_estimasi_apbu_bos= 0;
    $total_estimasi_apbu_intern= 0;
    $total_saldo_apbu = 0;
    $total_saldo_apbu_ypl = 0;
    $total_saldo_apbu_komite = 0;
    $total_saldo_apbu_intern = 0;
    $total_saldo_apbu_bos = 0;

    $recommendations = [];
    $pendapatan_id = [];
    $inventaris_id = [];
    $pengeluaran_id = [];
    $persentase = [];

    foreach($results as $result) {
      if(Str::startsWith($result->code_of_account,'4')) {
        array_push($pendapatan_id, $result->id);
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
        if($budget->approved == true) {
          $total_rapbu_pendapatan += $result->budgetDetailDraft->total;
          $total_rapbu_pendapatan_ypl += $result->budgetDetailDraft->ypl;
          $total_rapbu_pendapatan_komite += $result->budgetDetailDraft->committee;
          $total_rapbu_pendapatan_bos += $result->budgetDetailDraft->bos;
          $total_rapbu_pendapatan_intern += $result->budgetDetailDraft->intern;
        }
      } else {
        if(Str::startsWith($result->code_of_account,'13')) {
          array_push($inventaris_id, $result->id);
          array_push($inventaris,$result);
          $total_inventaris += $result->total;
          $total_inventaris_ypl += $result->ypl;
          $total_inventaris_komite += $result->committee;
          $total_inventaris_bos += $result->bos;
          $total_inventaris_intern += $result->intern;

          if($budget->approved == true) {
            $total_rapbu_inventaris += $result->budgetDetailDraft->total;
            $total_rapbu_inventaris_ypl += $result->budgetDetailDraft->ypl;
            $total_rapbu_inventaris_komite += $result->budgetDetailDraft->committee;
            $total_rapbu_inventaris_bos += $result->budgetDetailDraft->bos;
            $total_rapbu_inventaris_intern += $result->budgetDetailDraft->intern;
          }
        } else if(Str::startsWith($result->code_of_account,'5')) {
          array_push($pengeluaran_id, $result->id);
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

          if($budget->approved == true) {
            $total_rapbu_pengeluaran += $result->budgetDetailDraft->total;
            $total_rapbu_pengeluaran_ypl += $result->budgetDetailDraft->ypl;
            $total_rapbu_pengeluaran_komite += $result->budgetDetailDraft->committee;
            $total_rapbu_pengeluaran_bos += $result->budgetDetailDraft->bos;
            $total_rapbu_pengeluaran_intern += $result->budgetDetailDraft->intern;
          }
        }
      }

      if(isset($result->recommendations)) {
        foreach($result->recommendations as $recommendation) {
          $field = $recommendation['field'];
          $value = $recommendation['value'];
          $userGroupId = $recommendation['user_groups_id'];
          if(!isset($recommendations[$userGroupId])) {
            $recommendations[$userGroupId] = [
              'ypl' => null,
              'committee' => null,
              'intern' => null,
              'bos' => null,
            ];
          }

          if(floatVal($result->budgetDetailDraft[$field]) > 0) {
            $persentase[$field][$recommendation['budget_detail_drafts_id']] =
            floatVal($value)/floatVal($result->budgetDetailDraft[$field])*100;
          } else {
            $persentase[$field][$recommendation['budget_detail_drafts_id']] = 0;
          }

          $recommendations[$userGroupId][$field][$recommendation['budget_detail_drafts_id']] = $value;
        }
      }
    }

    $recommendation = $recommendations[10];
    if(isset($recommendation)) {
      foreach($recommendation as $field => $refs) {
        $fieldname = $field;
        if($field == 'committee') {
          $fieldname = 'komite';
        }
        if(isset($refs) && !empty($refs)) {
          foreach($refs as $ref => $value) {

            if(in_array($ref, $pendapatan_id)) {
              ${"total_pendapatan_rekomendasi_" . $fieldname} += floatval($value);
            } else if (in_array($ref, $pengeluaran_id)) {
              ${"total_pengeluaran_rekomendasi_" . $fieldname} += floatval($value);
            } else if (in_array($ref, $inventaris_id)) {
              ${"total_inventaris_rekomendasi_" . $fieldname} += floatval($value);
            }
          }
        }
      }
    }

    $recommendation = $recommendations[8];
    if(isset($recommendation)) {
      foreach($recommendation as $field => $refs) {
        $fieldname = $field;
        if($field == 'committee') {
          $fieldname = 'komite';
        }
        if(isset($refs) && !empty($refs)) {
          foreach($refs as $ref => $value) {
            if(in_array($ref, $pendapatan_id)) {
              ${"total_pendapatan_apbu_" . $fieldname} += floatval($value);
            } else if (in_array($ref, $pengeluaran_id)) {
              ${"total_pengeluaran_apbu_" . $fieldname} += floatval($value);
            } else if (in_array($ref, $inventaris_id)) {
              ${"total_inventaris_apbu_" . $fieldname} += floatval($value);
            }
          }
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

    $total_rapbu_estimasi = $total_rapbu_pendapatan - $total_rapbu_pengeluaran;
    $total_rapbu_estimasi_ypl = $total_rapbu_pendapatan_ypl - $total_rapbu_pengeluaran_ypl;
    $total_rapbu_estimasi_komite = $total_rapbu_pendapatan_komite - $total_rapbu_pengeluaran_komite;
    $total_rapbu_estimasi_bos = $total_rapbu_pendapatan_bos - $total_rapbu_pengeluaran_bos;
    $total_rapbu_estimasi_intern = $total_rapbu_pendapatan_intern - $total_rapbu_pengeluaran_intern;
    $total_rapbu_saldo = $total_rapbu_pendapatan - $total_rapbu_pengeluaran - $total_rapbu_inventaris;
    $total_rapbu_saldo_ypl = $total_rapbu_pendapatan_ypl - $total_rapbu_pengeluaran_ypl - $total_rapbu_inventaris_ypl;
    $total_rapbu_saldo_komite = $total_rapbu_pendapatan_komite - $total_rapbu_pengeluaran_komite - $total_rapbu_inventaris_komite;
    $total_rapbu_saldo_bos = $total_rapbu_pendapatan_bos - $total_rapbu_pengeluaran_bos - $total_rapbu_inventaris_bos;
    $total_rapbu_saldo_intern = $total_rapbu_pendapatan_intern - $total_rapbu_pengeluaran_intern - $total_rapbu_inventaris_intern;
    $status = ($total_rapbu_estimasi > 0) ? 'SURPLUS' : 'DEFISIT';

    $total_estimasi_rekomendasi = $total_pendapatan_rekomendasi - $total_pengeluaran_rekomendasi;
    $total_estimasi_rekomendasi_ypl = $total_pendapatan_rekomendasi_ypl - $total_pengeluaran_rekomendasi_ypl;
    $total_estimasi_rekomendasi_komite = $total_pendapatan_rekomendasi_komite - $total_pengeluaran_rekomendasi_komite;
    $total_estimasi_rekomendasi_bos = $total_pendapatan_rekomendasi_bos - $total_pengeluaran_rekomendasi_bos;
    $total_estimasi_rekomendasi_intern = $total_pendapatan_rekomendasi_intern - $total_pengeluaran_rekomendasi_intern;
    $total_saldo_rekomendasi = $total_pendapatan_rekomendasi - $total_pengeluaran_rekomendasi - $total_inventaris;
    $total_saldo_rekomendasi_ypl = $total_pendapatan_rekomendasi_ypl - $total_pengeluaran_rekomendasi_ypl - $total_inventaris_ypl;
    $total_saldo_rekomendasi_komite = $total_pendapatan_rekomendasi_komite - $total_pengeluaran_rekomendasi_komite - $total_inventaris_komite;
    $total_saldo_rekomendasi_bos = $total_pendapatan_rekomendasi_bos - $total_pengeluaran_rekomendasi_bos - $total_inventaris_bos;
    $total_saldo_rekomendasi_intern = $total_pendapatan_rekomendasi_intern - $total_pengeluaran_rekomendasi_intern - $total_inventaris_intern;
    $status = ($total_estimasi_rekomendasi > 0) ? 'SURPLUS' : 'DEFISIT';

    $total_estimasi_apbu = $total_pendapatan_apbu - $total_pengeluaran_apbu;
    $total_estimasi_apbu_ypl = $total_pendapatan_apbu_ypl - $total_pengeluaran_apbu_ypl;
    $total_estimasi_apbu_komite = $total_pendapatan_apbu_komite - $total_pengeluaran_apbu_komite;
    $total_estimasi_apbu_bos = $total_pendapatan_apbu_bos - $total_pengeluaran_apbu_bos;
    $total_estimasi_apbu_intern = $total_pendapatan_apbu_intern - $total_pengeluaran_apbu_intern;
    $total_saldo_apbu = $total_pendapatan_rekomendasi - $total_pengeluaran_rekomendasi - $total_inventaris;
    $total_saldo_apbu_ypl = $total_pendapatan_rekomendasi_ypl - $total_pengeluaran_rekomendasi_ypl - $total_inventaris_ypl;
    $total_saldo_apbu_komite = $total_pendapatan_rekomendasi_komite - $total_pengeluaran_rekomendasi_komite - $total_inventaris_komite;
    $total_saldo_apbu_bos = $total_pendapatan_rekomendasi_bos - $total_pengeluaran_rekomendasi_bos - $total_inventaris_bos;
    $total_saldo_apbu_intern = $total_pendapatan_rekomendasi_intern - $total_pengeluaran_rekomendasi_intern - $total_inventaris_intern;
    $status = ($total_estimasi_apbu > 0) ? 'SURPLUS' : 'DEFISIT';


    $data = array(
        'persentase' => $persentase,
        'pendapatan_id' => $pendapatan_id,
        'pengeluaran_id' => $pengeluaran_id,
        'inventaris_id' => $inventaris_id,
        'inventaris' => $inventaris,
        'ganjil' => $ganjil,
        'genap' => $genap,
        'recommendations' => $recommendations,
        'workflow' => $budget->workflow,
        'total_pendapatan' => $total_pendapatan,
        'total_pengeluaran' => $total_pengeluaran,
        'total_inventaris' => $total_inventaris,
        'total_pendapatan_ypl' => $total_pendapatan_ypl,
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
        'total_estimasi' => $total_estimasi,
        'total_estimasi_ypl' => $total_estimasi_ypl,
        'total_estimasi_komite' => $total_estimasi_komite,
        'total_estimasi_bos' => $total_estimasi_bos,
        'total_estimasi_intern' => $total_estimasi_intern,
        'total_saldo' => $total_saldo,
        'total_saldo_ypl' => $total_saldo_ypl,
        'total_saldo_komite' => $total_saldo_komite,
        'total_saldo_intern' => $total_saldo_intern,
        'total_saldo_bos' => $total_saldo_bos,
        'total_rapbu_pendapatan' => $total_rapbu_pendapatan,
        'total_rapbu_pengeluaran' => $total_rapbu_pengeluaran,
        'total_rapbu_inventaris' => $total_rapbu_inventaris,
        'total_rapbu_pendapatan_ypl' => $total_rapbu_pendapatan_ypl,
        'total_rapbu_pengeluaran_ypl' => $total_rapbu_pengeluaran_ypl,
        'total_rapbu_inventaris_ypl' => $total_rapbu_inventaris_ypl,
        'total_rapbu_pendapatan_komite' => $total_rapbu_pendapatan_komite,
        'total_rapbu_pengeluaran_komite' => $total_rapbu_pengeluaran_komite,
        'total_rapbu_inventaris_komite' => $total_rapbu_inventaris_komite,
        'total_rapbu_pendapatan_intern' => $total_rapbu_pendapatan_intern,
        'total_rapbu_pengeluaran_intern' => $total_rapbu_pengeluaran_intern,
        'total_rapbu_inventaris_intern' => $total_rapbu_inventaris_intern,
        'total_rapbu_pendapatan_bos' => $total_rapbu_pendapatan_bos,
        'total_rapbu_pengeluaran_bos' => $total_rapbu_pengeluaran_bos,
        'total_rapbu_inventaris_bos' => $total_rapbu_inventaris_bos,
        'total_rapbu_estimasi_ypl' => $total_rapbu_estimasi_ypl,
        'total_rapbu_estimasi_komite' => $total_rapbu_estimasi_komite,
        'total_rapbu_estimasi_bos' => $total_rapbu_estimasi_bos,
        'total_rapbu_estimasi_intern' => $total_rapbu_estimasi_intern,
        'total_rapbu_saldo' => $total_rapbu_saldo,
        'total_rapbu_saldo_ypl' => $total_rapbu_saldo_ypl,
        'total_rapbu_saldo_komite' => $total_rapbu_saldo_komite,
        'total_rapbu_saldo_intern' => $total_rapbu_saldo_intern,
        'total_rapbu_saldo_bos' => $total_rapbu_saldo_bos,
        'total_pendapatan_rekomendasi' => $total_pendapatan_rekomendasi,
        'total_pengeluaran_rekomendasi' => $total_pengeluaran_rekomendasi,
        'total_inventaris_rekomendasi' => $total_inventaris_rekomendasi,
        'total_pendapatan_rekomendasi_ypl' => $total_pendapatan_rekomendasi_ypl,
        'total_pengeluaran_rekomendasi_ypl' => $total_pengeluaran_rekomendasi_ypl,
        'total_inventaris_rekomendasi_ypl' => $total_inventaris_rekomendasi_ypl,
        'total_pendapatan_rekomendasi_komite' => $total_pendapatan_rekomendasi_komite,
        'total_pengeluaran_rekomendasi_komite' => $total_pengeluaran_rekomendasi_komite,
        'total_inventaris_rekomendasi_komite' => $total_inventaris_rekomendasi_komite,
        'total_pendapatan_rekomendasi_intern' => $total_pendapatan_rekomendasi_intern,
        'total_pengeluaran_rekomendasi_intern' => $total_pengeluaran_rekomendasi_intern,
        'total_inventaris_rekomendasi_intern' => $total_inventaris_rekomendasi_intern,
        'total_pendapatan_rekomendasi_bos' => $total_pendapatan_rekomendasi_bos,
        'total_pengeluaran_rekomendasi_bos' => $total_pengeluaran_rekomendasi_bos,
        'total_inventaris_rekomendasi_bos' => $total_inventaris_rekomendasi_bos,
        'total_estimasi_rekomendasi_ypl' => $total_estimasi_rekomendasi_ypl,
        'total_estimasi_rekomendasi_komite' => $total_estimasi_rekomendasi_komite,
        'total_estimasi_rekomendasi_bos' => $total_estimasi_rekomendasi_bos,
        'total_estimasi_rekomendasi_intern' => $total_estimasi_rekomendasi_intern,
        'total_saldo_rekomendasi' => $total_saldo_rekomendasi,
        'total_saldo_rekomendasi_ypl' => $total_saldo_rekomendasi_ypl,
        'total_saldo_rekomendasi_komite' => $total_saldo_rekomendasi_komite,
        'total_saldo_rekomendasi_intern' => $total_saldo_rekomendasi_intern,
        'total_saldo_rekomendasi_bos' => $total_saldo_rekomendasi_bos,
        'total_pendapatan_apbu' => $total_pendapatan_apbu,
        'total_pengeluaran_apbu' => $total_pengeluaran_apbu,
        'total_inventaris_apbu' => $total_inventaris_apbu,
        'total_pendapatan_apbu_ypl' => $total_pendapatan_apbu_ypl,
        'total_pengeluaran_apbu_ypl' => $total_pengeluaran_apbu_ypl,
        'total_inventaris_apbu_ypl' => $total_inventaris_apbu_ypl,
        'total_pendapatan_apbu_komite' => $total_pendapatan_apbu_komite,
        'total_pengeluaran_apbu_komite' => $total_pengeluaran_apbu_komite,
        'total_inventaris_apbu_komite' => $total_inventaris_apbu_komite,
        'total_pendapatan_apbu_intern' => $total_pendapatan_apbu_intern,
        'total_pengeluaran_apbu_intern' => $total_pengeluaran_apbu_intern,
        'total_inventaris_apbu_intern' => $total_inventaris_apbu_intern,
        'total_pendapatan_apbu_bos' => $total_pendapatan_apbu_bos,
        'total_pengeluaran_apbu_bos' => $total_pengeluaran_apbu_bos,
        'total_inventaris_apbu_bos' => $total_inventaris_apbu_bos,
        'total_estimasi_apbu_ypl' => $total_estimasi_apbu_ypl,
        'total_estimasi_apbu_komite' => $total_estimasi_apbu_komite,
        'total_estimasi_apbu_bos' => $total_estimasi_apbu_bos,
        'total_estimasi_apbu_intern' => $total_estimasi_apbu_intern,
        'total_saldo_apbu' => $total_saldo_apbu,
        'total_saldo_apbu_ypl' => $total_saldo_apbu_ypl,
        'total_saldo_apbu_komite' => $total_saldo_apbu_komite,
        'total_saldo_apbu_intern' => $total_saldo_apbu_intern,
        'total_saldo_apbu_bos' => $total_saldo_apbu_bos,
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

      if(isset($data['file'])) {
        $filepath = $data['file']['path'];
        if(Storage::disk('temp')->exists($filepath)) {
          $info = pathinfo(storage_path('app/temp').$filepath);
          $file = Storage::disk('temp')->get($filepath);
          $extension = $info['extension'];
          $size = Storage::disk('temp')->size($filepath);
          $filename = 'budget_'.$budgetDetail->head.'_'.$budgetDetail->id.'.'.$extension;
          $newPath = Storage::move('/temp/'.$filepath, '/public/'.$filename);

          $file = $budgetDetail->file()->create([
            'name' => $filename,
            'display_name' => $data['file']['filename'],
            'path' => $newPath,
            'extension' => $extension,
            'size' => $size
          ]);
        }
      }
      $budgetDetail->load('parameter_code', 'file');
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
      $result = [];
      if(isset($data->recommendations[8])) {
        $recommendations = $data->recommendations[8];

        foreach($recommendations as $pos => $ids) {
          if(isset($ids)) {
            foreach($ids as $id => $value) {
              $value = (float) $value;

              if(isset($value) && $value > 0) {
                if(!isset($result[$id])) {
                  $draft = BudgetDetailDrafts::find($id)->toArray();
                  $result[$id] = $draft;
                  $result[$id]['total'] = 0;
                }
                $result[$id][$pos] = $value;
                $result[$id]['total'] += $value;
              } else {
                if(isset($result[$id])) {
                  $result[$id][$pos] = 0;
                }
              }
            }
          }
        }

        if(isset($result)) {
          foreach($result as $id => $values) {
            $budgetDetails = BudgetDetails::updateOrCreate(
              ['unique_id' => $values['unique_id']],
              $values
            );
          }
        }

      }
      $budget->load('budgetDetails', 'budgetDetailDrafts', 'budgetDetailDrafts.recommendations');

      $this->updateWorkflow($budget, true);
    }

    return $budget;
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
