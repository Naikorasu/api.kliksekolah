<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NonBudget;

class NonBudgetController extends Controller
{
    public function list(Request $request) {
      $nonBudgets = NonBudget::paginate(5);
      return response()->json([
          'data' => $nonBudgets
      ],200);
    }

    public function get(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $nonBudget = NonBudget::where([
        ['id', '=', $request->id]
      ]);

      return response()->json([
          'data' => $nonBudgets
      ],200);
    }

    public function add(Request $request) {
      $request->validate([
        'code_of_account' => 'required',
        'amount' => 'required',
        'activity' => 'required'
      ]);

      $date = ($request->date) ? date('Y-m-d', strtotime($request->date)) : date('Y-m-d');
      $nonBudget = new NonBudget();
      $nonBudget->file_number = $request->file_number;
      $nonBudget->code_of_account = $request->code_of_account;
      $nonBudget->activity = $request->activity;
      $nonBudget->description = $request->description;
      $nonBudget->amount = $request->amount;
      $nonBudget->date = $date;
      $nonBudget->save();

      return response()->json([
        'message' => 'Successfully saved non budget request.',
        'data' => $nonBudget,
      ],200);
    }

    public function edit(Request $request) {
      $request->validate([
        'id' => 'required',
        'code_of_account' => 'required',
        'amount' => 'required',
        'activity' => 'required'
      ]);

      $nonBudget = NonBudget::where([
        ['id', '=', $request->id],
        ['submitted', '=', false]
      ])->first();

      if($nonBudget) {
        $nonBudget->file_number = $request->file_number;
        $nonBudget->code_of_account = $request->code_of_account;
        $nonBudget->activity = $request->activity;
        $nonBudget->description = $request->description;
        $nonBudget->amount = $request->amount;
        $nonBudget->save();
        return response()->json([
          'message' => 'Successfully saved non budget request.',
          'data' => $nonBudget
        ],200);
      } else {
        return response()->json([
          'message' => 'Failed to save non budget request. ID not found.'
        ],400);
      }
    }

    public function submit() {
      $request->validate([
        'id' => 'required'
      ]);

      $nonBudget = NonBudget::where([
        ['id', '=', $request->id]
      ]);

      if($nonBudget) {
        if($nonBudget->submitted == true) {
          return response()->json([
            'message' => 'The request has been submitted.'
          ],200);
        }
        else {
          $nonBudget->submitted = true;
          $nonBudget->save();
          return response()->json([
            'message' => 'Succesfully saved the request.'
          ],200);
        }
      } else {
        return response()->json([
          'message' => 'ID not found.'
        ],400);
      }
    }

    public function updateStatus() {
      $request->validate([
        'id' => 'required',
        'submitted' => 'required'
      ]);

      $nonBudget = NonBudget::where([
        ['id', '=', $request->id],
        ['sumitted', '=', true]
      ]);

      if($nonBudget) {
        $nonBudget->submitted = $request->submitted;
        $nonBudget->save();
        return response()->json([
          'message' => 'Succesfully saved the request.'
        ],200);
      } else {
        return response()->json([
          'message' => 'ID not found.'
        ],400);
      }
    }
}
