<?php

namespace App\Http\Controllers;

use App\CodeClass;
use Illuminate\Http\Request;

class CodeAccountingController extends Controller
{
    //

    public function list(Request $request) {

        $user = $request->user();
        $user_email = $user->email;


        $result = array();

        $data = CodeClass::with('group')->get();

        $arr_data = array (
            'data' => $data,
        );
        array_push($result, $arr_data);


        return response()->json([
            'message' => 'Load Parameter Data Success',
            'result' => $result,
        ], 200);
    }
}
