<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class TestController extends Controller
{
    //
    public function index(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        //$headers = apache_request_headers();
        $headers = $_SERVER;

        return response()->json([
            'message' => $request->name,
            'result' => $headers,
        ], 201);
    }
}
