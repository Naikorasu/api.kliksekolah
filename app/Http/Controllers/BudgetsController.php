<?php

namespace App\Http\Controllers;

use Auth;
use App\Budgets;
use App\BudgetAccounts;
use App\BudgetDetails;
use App\User;
use App\Classes\FunctionHelper;
use App\CodeAccount;
use App\Exceptions\DataNotFoundException;
use Illuminate\Http\Request;
use App\Services\BudgetsService;
use App\Services\BudgetDetailsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BudgetsController extends Controller
{

    private $budgetService;
    private $budgetDetailService;

    public function __construct(BudgetsService $budgetService, BudgetDetailsService $budgetDetailService) {
      $this->budgetService = $budgetService;
      $this->budgetDetailService = $budgetDetailService;
    }

    //BUDGET HEADER
    public function list_head(Request $request)
    {
        $filters = $request->filters;

        $result = $this->budgetService->getList($request->filters);

        return response()->json($result, 200);
    }

    public function add_head(Request $request)
    {

        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'periode' => 'required|integer',
            'create_by' => 'required',
            'desc' => 'string',
        ]);

        $fh = New FunctionHelper();
        $unique_id_head = $fh::generate_unique_key($user_email . ";" . "HEAD;");

        $data_head = array(
            'unique_id' => $unique_id_head,
            'periode' => $request->periode,
            'create_by' => $request->create_by,
            'desc' => $request->desc,
        );
        $budget_head = New Budgets($data_head);
        $budget_head->save();

        for ($y = 0; $y <= 4; $y++) {

            $prefix_code_of_account = $y + 1;
            $account_type = $prefix_code_of_account . "0000";

            $fh = New FunctionHelper();
            $unique_id_account = $fh::generate_unique_key($user_email . ";" . "ACCOUNT;" . $account_type . ";");

            switch ($account_type) {
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
                'account_type' => $account_type,
                'account_info' => $account_info,
            );
            $budget_account = New BudgetAccounts($data_account);
            $budget_account->save();
        }

        return response()->json([
            'message' => 'Successfully Add Budgets Head Data'
        ], 201);
    }

    public function delete_head(Request $request)
    {
        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'head_unique_id' => 'required',
        ]);

        $deleted_budget = Budgets::where('unique_id', $request->head_unique_id)->delete();
        $deleted_account = BudgetAccounts::where('head', $request->head_unique_id)->delete();
        $deleted_detail = BudgetDetails::where('head', $request->head_unique_id)->delete();

        if ($deleted_budget > 0 || $deleted_account > 0 || $deleted_detail > 0) {
            $message = "Successfuly Delete Data with Unique ID $request->head_unique_id";
            $result = array(
                'data_budget' => $deleted_budget,
                'data_account' => $deleted_account,
                'data_detail' => $deleted_detail,
            );
        } else {
            $message = "No Head Data Has Been Delete";
            $result = array();
        }

        return response()->json([
            'message' => $message,
            'result' => $result,
        ], 201);

    }


    //BUDGET ACCOUNT

    /*
    public function data_account(Request $request) {

    }

    public function add_account(Request $request) {

    }

    public function delete_account(Request $request) {

    }
    */

    private function runWorkflow($type, $budgetHead) {
      $currentUser = User::with('userGroup')->find(Auth::user()->id);
      $currentUserGroups = $currentUser->user_group;
      $lastUser = User::with('userGroup')->find($budgetHead->user_id);
      $lastUserGroups = $lastUser->user_group;

      $workflow = [
        'result' => [
          'submitted' => $budgetHead->submitted,
          'approved' => $budgetHead->approved,
          'user_id' => $currentUser->id
        ],
        'createRevision' => false
      ];

      if($budget->approved) {
        return false;
      }

      switch($type) {
        case 'SAVE':
          if($budgetHead->approved == false) {
            if($budgetHead->submitted) {
              if($currentUserGroups->priority < $lastUserGroups->priority) {
                $workflow->createRevision = true;
                $workflow->result->submitted = false;
              } else if($lastUserGroups->priority == 1 && $currentUserGroups->priority == 5) {
                $workflow->createRevision = true;
              } else {
                $workflow->$result->user_id = $lastUser->id;
              }
            } else {
              if($currentUserGroups->priority == $lastUserGroups->priority) {
                $result->submitted = false;
              } else {
                $result->user_id = $lastUser->id;
              }
            }
          }
          break;
        case 'SUBMIT':
          if($currentUserGroups->priority > 1) {
            $result->submitted = true;
          }
          break;
        case 'APPROVE':
          if($currentUserGroups->priority == 1) {
            $result->submitted = true;
            $result->approved = true;
          }
          break;
        case 'REJECT':
          if($currentUserGroups->priority == 1) {
            $result->submitted = false;
            $result->approved = false;
          }
          break;
        default:
          break;
      }

      return $result;
    }


}
