<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetAccount;
use App\BudgetDetail;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    //

    //BUDGET HEADER
    public function list_head(Request $request)
    {
        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'periode' => 'required|integer',
        ]);

        $result = array();

        $data = Budget::where('periode', $request->periode)->where('create_by', $user_email)->orderBy('created_at', 'DESC')->with('account')->paginate(5);

        array_push($result, $data);

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


        $unique_id_head = generate_unique_key($user_email . ";" . "HEAD;");

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
            $unique_id_account = generate_unique_key($user_email . ";" . "ACCOUNT;" . $account_type . ";");

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
            'unique_id' => 'required',
        ]);

        $deleted_budget = Budget::where('unique_id', $request->unique_id)->delete();
        $deleted_account = BudgetAccount::where('head', $request->unique_id)->delete();
        $deleted_detail = BudgetDetail::where('head', $request->unique_id)->delete();

        if ($deleted_budget > 0 || $deleted_account > 0 || $deleted_detail > 0) {
            $message = "Successfuly Delete Data with Unique ID $request->unique_id";
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
            'unique_id' => 'required'
        ]);

        $result = array();

        $data = BudgetAccount::where('unique_id', $request->unique_id)->with('detail')->get();

        $data_result = array (
            
            'data' => $data,
        );

        array_push($result, $data_result);

        return response()->json([
            'message' => 'Load Data Detail Success',
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
            'data' => 'required',
        ]);

        $header = $request->header;
        $process_data = json_decode($request->data, true);

        /*
        $data = array();

        foreach ($process_data as $key => $val) {
            $push = array(
                'key' => $key,
                'val' => $val,
            );

            array_push($data,$push);

            //$budget_detail = New BudgetDetail($data);
            //$budget_detail->save();
        }
        */


        return response()->json([
            'message' => 'Successfully Add Budget Row Detail',
            'header' => $header,
            'data' => $process_data,
            'string' => $request->data,
        ], 200);


    }

    public function delete_detail(Request $request)
    {

        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'id' => 'required',
        ]);
    }


}
