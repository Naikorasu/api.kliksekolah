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
      $this->middleware('auth');
      $this->budgetService = $budgetService;
      $this->budgetDetailService = $budgetDetailService;
    }

    //BUDGET HEADER
    public function list_head(Request $request)
    {
        $result = $this->budgetService->getList($request->filters, $request->unit_id);

        return response()->json($result, 200);
    }

    public function add_head(Request $request)
    {

        $request->validate([
            'periode' => 'required|integer',
            'desc' => 'string',
        ]);

        $data = $this->budgetService->save($request, $request->unit_id);

        return response()->json([
            'message' => 'Successfully Add Budgets Head Data',
            'data' => $data
        ], 201);
    }

    public function delete_head(Request $request)
    {
        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'head_unique_id' => 'required',
        ]);

        $budget = Budgets::where('unique_id',$request->head_unique_id)->first();

        $deleted_account = BudgetAccounts::where('head', $budget['unique_id'])->forceDelete();
        $deleted_detail = BudgetDetails::where('head', $budget['unique_id'])->forceDelete();
        $budget->forceDelete();

        if (isset($budget)) {
            $message = "Successfuly Deleted Data with Unique ID ".$budget['unique_id'];
            $result = array(
                'data_budget' => $budget
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
