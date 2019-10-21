<?php

namespace App\Services;

use Auth;
use App\Exceptions\DataNotFoundException;
use App\BudgetDetailDrafts;
use App\BudgetAccounts;
use App\SchoolUnits;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Budgets;

class BudgetsService extends BaseService {

  /**
   * Report or log an exception.
   *
   * @param  \Exception  $exception
   * @return void
   */
  public function getList($filters=[], $unit_id = null) {

    $conditions = $this->buildFilters($filters);
    $user = Auth::user();
    $user->load('userGroup');
    $userGroup = $user->userGroup->name;

    try {
      if(!isset($unit_id) || $unit_id == 0) {
        $unit_id = $user->prm_school_units_id;
        if((!isset($unit_id))) {
          if (isset($user->prm_perwakilan_id)) {
            $unit_id = SchoolUnits::select('id')
              ->where('prm_perwakilan_id', $user->prm_perwakilan_id)
              ->get()->pluck('id')->all();
          } else {
            $unit_id = SchoolUnits::select('id')->get()->pluck('id')->all();
          }
        }
      }

      if($userGroup == 'Korektor Pusat'
        || $userGroup =='Manager Keuangan' || $userGroup == 'Bendahara') {
          $query = Budgets::withUnitId($unit_id)
            ->where($conditions)
            ->orderBy('created_at', 'DESC')
            ->with('account', 'workflow', 'school_unit')
            ->whereHas('workflow', function($q) use($userGroup) {
                $q->where('next_role', $userGroup);
            })
            ->paginate(5);
      } else {
        $query = Budgets::withUnitId($unit_id)
          ->where($conditions)
          ->orderBy('created_at', 'DESC')
          ->with('account', 'workflow', 'school_unit')
          ->paginate(5);
      }
      return $query;
    } catch(ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function save($data, $unit_id = null) {
    $user = Auth::user()->load('userGroup');
    $user_email = $user->email;

    if($user->userGroup->name != 'Keuangan Sekolah'
      && $user->userGroup->name != 'Manager Keuangan'
      && $user->userGroup->name != 'Korektor Perwakilan') {
        throw new Exception('User not allowed to save');
    }
    $unique_id_head = $this->generateUniqueId($user_email . ";" . "HEAD;");

    $data_head = array(
        'unique_id' => $unique_id_head,
        'periode' => $data->periode,
        'create_by' => $data->create_by,
        'desc' => $data->desc,
    );
    $budget_head = New Budgets($data_head);
    $budget_head->save();

    for ($y = 0; $y <= 4; $y++) {

        $prefix_code_of_account = $y + 1;
        $accountType = $prefix_code_of_account . "0000";

        $unique_id_account = $this->generateUniqueId($accountType);

        switch ($accountType) {
            case '10000' :
                $account_info = "AKTIVA";
                break;

            case '20000' :
                $account_info = "PASIVA";
                break;

            case '30000' :
                $account_info = "EKUITAS";
                break;

            case '40000' :
                $account_info = "PENDAPATAN";
                break;

            case '50000' :
                $account_info = "BEBAN";
                break;

            default:
                break;
        }

        $data_account = array(
            'unique_id' => $unique_id_account,
            'head' => $unique_id_head,
            'account_type' => $accountType,
            'account_info' => $account_info,
        );
        $budget_account = New BudgetAccounts($data_account);
        $budget_account->save();
    }

    $this->updateEntityUnit($budget_head, $unit_id);

    return $budget_head;
  }

  public function edit() {

  }

  public function submit($id) {
    $budget_head = Budgets::find($id);
    $this->updateWorkflow($budget_head);
  }

  public function approve() {
    $budget_head = Budgets::find($id);
    $this->updateWorkflow($budget_head,true);
  }

  public function reject() {
    $budget_head = Budgets::find($id);
    $this->updateWorkflow($budget_head,false,true);
  }

  public function getPeriodes($filters=[]) {
    $conditions = $this->buildFilters($filters);

    $result = Budgets::where($conditions)->select(DB::raw('distinct(periode) as periodes'));

    return $result;
  }

  public function validateAddBudget($data) {
    $user = Auth::user()->load('userGroup', 'school_unit');
    $budgetCount = Budgets::where('periode', $data->periode)->whereHas('school_unit', function($q) {
      $q->where('prm_school_units_id', $user->prm_school_units_id);
    })->count();

    if($budgetCount > 0) {
      return false;
    }

    return true;
  }
}
