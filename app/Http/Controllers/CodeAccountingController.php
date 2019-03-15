<?php

namespace App\Http\Controllers;

use App\CodeCategory;
use App\CodeClass;
use App\CodeGroup;
use Illuminate\Http\Request;

class CodeAccountingController extends Controller
{
    //

    public function list(Request $request)
    {
        $user = $request->user();
        $user_email = $user->email;

        $request->validate([
            'code' => '',
        ]);

        //$data_category = CodeCategory::with('group')->get();
        //$data_group = CodeGroup::with('account')->get();

        if ($request->code == '') {
            $data_class = CodeClass::with('category')->get();
        } else {
            $data_class = CodeClass::where('code', $request->code)->with('category')->get();
        }

        foreach ($data_class as $classes => $class) {

            $data_category = $class['category'];

            foreach ($data_category as $categories => $category) {
                $category_code = $category['code'];
                $data_group_account = CodeGroup::where('category', $category_code)->with('account')->get();
                $data_category[$categories]['group'] = $data_group_account;
            }
        }

        $result = array(
            'data' => $data_class,
        );



        return response()->json([
            'message' => 'Load Parameter Data Success',
            'result' => $result,
        ], 200);
    }
}
