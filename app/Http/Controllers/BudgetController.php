<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetAccount;
use App\BudgetDetail;
use App\Classes\FunctionHelper;
use App\CodeAccount;
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

        $data = Budget::where('periode', $request->periode)->where('create_by', $user_email)->orderBy('created_at', 'DESC')->with('account')->paginate(5);

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

        //$data = BudgetAccount::where('unique_id', $request->unique_id)->with('detail')->get();

        $data_ganjil = BudgetDetail::where('account',$request->unique_id)->where('semester', 1)->with('parameter_code')->get();
        $data_genap = BudgetDetail::where('account',$request->unique_id)->where('semester', 2)->with('parameter_code')->get();


        $data = array(
            'ganjil' => $data_ganjil,
            'genap' => $data_genap,
        );

        /*
        foreach ($data as $key => $val) {
            $data_detail = $val['detail'];


            foreach ($data_detail as $k => $v) {

                $code_of_account = $v['code_of_account'];
                $semester = $v['semester'];

                $data_code_of_account = CodeAccount::where('code', $code_of_account)->get();

                //$data_detail[$k]['code_of_account'] = $data_code_of_account;

                $data[$key]['detail'][$k]['code_of_account'] = $data_code_of_account[0];
            }

        }
        */

        $result = array(
            'data' => $data,
        );

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
            'account_type' => 'required|integer',
            'data' => 'required',
        ]);

        $process_data = json_decode($request->data, true);

        $result = array();

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

    public function delete_detail(Request $request)
    {

        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'unique_id' => 'required',
        ]);
    }


}
