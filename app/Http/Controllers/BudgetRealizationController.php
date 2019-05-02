<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BudgetRealizationController extends Controller
{
    public function list(Request $request) {

    }

    public function add(Request $request) {
        $request->validate([
          'budget_detail_unique_id' => 'required',
          'filename' => 'required',
          'amount' => 'required'
        ]);
    }
}
