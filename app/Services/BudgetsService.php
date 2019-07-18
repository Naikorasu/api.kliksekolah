<?php

namespace App\Services;

use Auth;
use App\Exceptions\DataNotFoundException;
use App\BudgetAccounts;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Budgets;

class BudgetsService extends BaseService {

  /**
   * Report or log an exception.
   *
   * @param  \Exception  $exception
   * @return void
   */
  public function getList($filters=[]) {

    $conditions = $this->buildFilters($filters);

    try {
      $unit_id = Auth::user()->prm_school_units_id;
      $query = Budgets::where($conditions)->orderBy('created_at', 'DESC')->with('account');

      if(!isset($unit_id)) {
        return $query->paginate(5);
      } else {
        return $query->withUnitId($unit_id)->paginate(5);

      }
    } catch(ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function save($data) {
    $user = $data->user();
    $user_email = $user->email;

    $unique_id_head = $this->generateUniqueId($user_email . ";" . "HEAD;");

    $data_head = array(
        'unique_id' => $unique_id_head,
        'periode' => $data->periode,
        'create_by' => $data->create_by,
        'desc' => $data->desc,
    );
    $budget_head = New Budgets($data_head);
    $budget_head->save();

    $this->updateEntityUnit($budget_head);

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
}
