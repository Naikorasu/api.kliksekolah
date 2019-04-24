<?php

namespace App\Http\Controllers;

use Auth;
use App\Budget;
use App\BudgetAccount;
use App\BudgetDetail;
use App\User;
use App\Classes\FunctionHelper;
use App\CodeAccount;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    //

    //BUDGET HEADER
    public function list_head(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user_email = $user->email;


        $request->validate([
            'periode' => 'required|integer',
        ]);

        $data = Budget::where('periode', $request->periode)->orderBy('created_at', 'DESC')->with('account')->paginate(5);

        $result = array(
            'data' => $data,
        );

        return response()->json([
            'message' => 'Load Data Budget Success',
            'result' => $result,
        ], 200);
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
        $budget_head = New Budget($data_head);
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
            $budget_account = New BudgetAccount($data_account);
            $budget_account->save();
        }

        return response()->json([
            'message' => 'Successfully Add Budget Head Data'
        ], 201);
    }

    public function delete_head(Request $request)
    {
        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'head_unique_id' => 'required',
        ]);

        $deleted_budget = Budget::where('unique_id', $request->head_unique_id)->delete();
        $deleted_account = BudgetAccount::where('head', $request->head_unique_id)->delete();
        $deleted_detail = BudgetDetail::where('head', $request->head_unique_id)->delete();

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


    //BUDGET DETAIL


    public function list_detail(Request $request)
    {
        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'account_unique_id' => 'required'
        ]);

        $code_of_account = $request->code_of_account;
        $with_remains = $request->with_remains;

        //$data = BudgetAccount::where('unique_id', $request->unique_id)->with('detail')->get();
        $data_ganjil = BudgetDetail::where('account', $request->account_unique_id)->where('semester', 1)->with('parameter_code')->with('revisions');
        $data_genap = BudgetDetail::where('account', $request->account_unique_id)->where('semester', 2)->with('parameter_code')->with('revisions');

        if($code_of_account) {
          $data_ganjil = $data_ganjil->where('code_of_account', $code_of_account);
          $data_genap = $data_genap->where('code_of_account', $code_of_account);
        }

        if($with_remains) {
          $data_ganjil = $data_ganjil->withRemains();
          $data_genap = $data_genap->withRemains();
        }

        $data = array(
            'ganjil' => $data_ganjil->get(),
            'genap' => $data_genap->get(),
        );

        $result = array(
            'data' => $data,
        );

        return response()->json([
            'message' => 'Load Data Detail Success',
            'result' => $result,
        ], 200);
    }



    public function list_detail_rapbu(Request $request)
    {
        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'head_unique_id' => 'required'
        ]);

        //$data = BudgetAccount::where('unique_id', $request->unique_id)->with('detail')->get();

        $data_pendapatan = BudgetDetail::where('head', $request->head_unique_id)->where('code_of_account','like','4%')->with('parameter_code')->get();
        $data_pengeluaran = BudgetDetail::where('head', $request->head_unique_id)->where('code_of_account','like','5%')->with('parameter_code')->get();

        $total_pendapatan = BudgetDetail::where('head',$request->head_unique_id)->where('code_of_account','like','4%')->sum('total');
        $total_pengeluaran = BudgetDetail::where('head',$request->head_unique_id)->where('code_of_account','like','5%')->sum('total');

        $estimasi_surplus_defisit = $total_pendapatan - $total_pengeluaran;

        if($total_pendapatan >= $total_pengeluaran) {
            $status_surplus_defisit = "SURPLUS";
            $saldo = $total_pendapatan - $total_pengeluaran;
        }
        else {
            $status_surplus_defisit = "DEFISIT";
            $saldo = 0;
        }

        $data = array(
            'pengeluaran' => $data_pengeluaran,
            'pendapatan' => $data_pendapatan,
            'total_pendapatan' => $total_pendapatan,
            'total_pengeluaran' => $total_pengeluaran,
            'status_surplus_defisit' => $status_surplus_defisit,
            'estimasi_surplus_defisit' => $estimasi_surplus_defisit,
            'saldo' => $saldo,
        );

        $result = array(
            'data' => $data,
        );

        return response()->json([
            'message' => 'Load Data Detail All Success',
            'result' => $result,
        ], 200);
    }

    public function add_detail(Request $request)
    {
        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'head_unique_id' => 'required',
            'account_unique_id' => 'required',
            'account_type' => 'required|integer',
            'data' => 'required',
        ]);

        $process_data = json_decode($request->data, true);

        $unique_id_head = $request->head_unique_id;
        $unique_id_account = $request->account_unique_id;
        $account_type = $request->account_type;

        foreach ($process_data as $key => $val) {

            $semester = $val['semester'];
            $code_of_account = $val['coa'];
            $title = $val['title'];
            $quantity = $val['quantity'];
            $price = $val['price'];
            $term = $val['term'];
            $ypl = $val['ypl'];
            $committee = $val['committee'];
            $intern = $val['intern'];
            $bos = $val['bos'];
            $total = $val['total'];
            $desc = $val['desc'];

            $fh = New FunctionHelper();
            $unique_id_detail = $fh::generate_unique_key($user_email . ";" . "DETAIL" . ";" . $account_type . ";" . $code_of_account . ";");

            $data = array(
                'unique_id' => $unique_id_detail,
                'head' => $unique_id_head,
                'account' => $unique_id_account,
                'semester' => $semester,
                'code_of_account' => $code_of_account,
                'title' => $title,
                'quantity' => $quantity,
                'price' => $price,
                'term' => $term,
                'ypl' => $ypl,
                'committee' => $committee,
                'intern' => $intern,
                'bos' => $bos,
                'total' => $total,
                'desc' => $desc,
            );

            $budget_detail = New BudgetDetail($data);
            $budget_detail->save();
        }

        if ($budget_detail) {
            return response()->json([
                'message' => 'Successfully Add Budget Row Detail',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Failed Add Budget Row Detail',
                'error' => $budget_detail,
            ], 200);
        }
    }

    public function edit_detail(Request $request)
    {
        $request->validate([
            'head_unique_id' => 'required',
            'account_unique_id' => 'required',
            'account_type' => 'required|integer',
            'data' => 'required',
        ]);

        $process_data = json_decode($request->data, true);

        $budgetHead = Budget::find($unique_id_head);

        $workflowResult = $this->runWorkflow('SAVE', $budgetHead);

        foreach ($process_data as $key => $val) {

            $unique_id_detail = $val['unique_id'];

            $update_data = array(
                'code_of_account' => $val['coa'],
                'title' => $val['title'],
                'quantity' => $val['quantity'],
                'price' => $val['price'],
                'term' => $val['term'],
                'ypl' => $val['ypl'],
                'committee' => $val['committee'],
                'intern' => $val['intern'],
                'bos' => $val['bos'],
                'total' => $val['total'],
                'desc' => $val['desc'],
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $budgetDetail = BudgetDetail::where('unique_id', $unique_id_detail)->first();

            if($workflowResult->createRevision){
              $budgetRevision = new BudgetRevisions();
              $budgetRevision->budget_detail_unique_id = $unique_id_detail;
              $budgetRevision->original_values = json_encode($budgetDetail);
              $budgetRevision->revised_values = json_encode($update_data);
              $budgetRevision->user_id = Auth::user()->id;
              $budgetRevision->save();
            } else {
              $budgetRevision = $budgetDetail->update($update_data);
            }

            if ($budgetRevision) {
                return response()->json([
                    'message' => 'Successfully Update Budget Row Detail',
                    'result' => $budgetRevision,
                ], 200);

            } else {

                return response()->json([
                    'message' => 'Failed Update Budget Row Detail',
                    'error' => $budgetRevision,
                ], 401);
            }
        }
    }

    public function delete_detail(Request $request)
    {
        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'detail_unique_id' => 'required',
        ]);

        $delete = BudgetDetail::where('unique_id', $request->detail_unique_id)->delete();

        if ($delete) {
            return response()->json([
                'message' => 'Successfully Delete Budget Row Detail',
                'result' => $delete,
            ], 200);

        } else {

            return response()->json([
                'message' => 'Failed Delete Budget Row Detail',
                'error' => $delete,
            ], 401);
        }

    }

    private function runWorkflow($type, $budgetHead) {
      $currentUser = User::with('userGroup')->find(Auth::user()->id);
      $currentUserGroup = $currentUser->user_group;
      $lastUser = User::with('userGroup')->find($budgetHead->user_id);
      $lastUserGroup = $lastUser->user_group;

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
              if($currentUserGroup->priority < $lastUserGroup->priority) {
                $workflow->createRevision = true;
                $workflow->result->submitted = false;
              } else if($lastUserGroup->priority == 1 && $currentUserGroup->priority == 5) {
                $workflow->createRevision = true;
              } else {
                $workflow->$result->user_id = $lastUser->id;
              }
            } else {
              if($currentUserGroup->priority == $lastUserGroup->priority) {
                $result->submitted = false;
              } else {
                $result->user_id = $lastUser->id;
              }
            }
          }
          break;
        case 'SUBMIT':
          if($currentUserGroup->priority > 1) {
            $result->submitted = true;
          }
          break;
        case 'APPROVE':
          if($currentUserGroup->priority == 1) {
            $result->submitted = true;
            $result->approved = true;
          }
          break;
        case 'REJECT':
          if($currentUserGroup->priority == 1) {
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
