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

        $code = $request->code;

        //$data_category = CodeCategory::with('group')->get();
        //$data_group = CodeGroup::with('account')->get();

        $data_class = CodeClass::with('category', 'category.group', 'category.group.account');
        if (isset($code)) {
            $data_class = CodeClass::whereNotNull('code')
            ->where('code', 'like', $code.'%')
            ->orWhereHas('category.group.account', function($q) use($code) {
              $q->where('code','like', $code.'%');
            })
            ->orWhereHas('category.group', function($q) use($code) {
              $q->where('code','like', $code.'%');
            })
            ->orWhereHas('category', function($q) use($code) {
              $q->where('code','like', $code.'%');
            });
        }

        $data_class = $data_class->get();

        foreach ($data_class as $classes => $class) {

            $data_category = $class['category'];

            foreach ($data_category as $categories => $category) {
                $category_code = $category['code'];
                $data_group_account = CodeGroup::where('category', $category_code)->with('account')->get();
                $data_category[$categories]['group'] = $data_group_account;
            }
            $data_class[$classes]['category'] = $data_category;
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
