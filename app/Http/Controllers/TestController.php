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

        return response()->json([
            'message' => $request->name
        ], 201);
    }
}
