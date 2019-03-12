<?php

namespace App\Http\Controllers;

use App\Budget;
use App\BudgetDetail;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    //

    //BUDGET HEADER
    public function list_header(Request $request) {

        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'periode' => 'required|integer',
        ]);

        $result = array();

        $data = Budget::where('periode', $request->periode)->where('create_by', $user_email)->orderBy('created_at', 'DESC')->with('detail')->get();

        $arr_data = array (
            'data' => $data,
        );
        array_push($result, $arr_data);


        return response()->json([
            'message' => 'Load Data Budget Success',
            'result' => $result,
        ], 201);
    }

    public function add_header(Request $request) {

        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'periode' => 'required|integer',
            'create_by' => 'required',
            'desc' => 'string',
        ]);

        $data = array (
            'periode' => $request->periode,
            'create_by' => $request->create_by,
            'desc' => $request->desc,
        );
        $budget_header = New Budget($data);
        $budget_header->save();

        return response()->json([
            'message' => 'Successfully Add Budget Header'
        ], 201);
    }

    public function delete_header(Request $request) {

        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'id' => 'required',
        ]);

        $deletedRows = Budget::where('id', $request->id)->delete();

        if($deletedRows > 0) {
            $message = "Successfuly Delete $deletedRows Header at ID $request->id";
        }
        else {
            $message = "No Header Has Been Delete ";
        }

        return response()->json([
            'message' => $message
        ], 201);

    }



    //BUDGET DETAIL

    public function data_detail(Request $request) {

        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'header' => 'required'
        ]);
    }

    public function add_detail(Request $request) {

        $user = $request->user();
        $user_email = $user->email;




        $request->validate([
            'header' => 'required',
            'data' => 'required',
        ]);

        $header = $request->header;
        $process_data = json_decode($request->data,true);

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
        ], 201);


    }

    public function delete_detail(Request $request) {

        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'id' => 'required',
        ]);
    }




}
