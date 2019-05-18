<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NonBudgets;

class NonBudgetsController extends Controller
{
    public function list(Request $request) {
      $data = NonBudgets::paginate(5);
      return response()->json($data,200);
    }

    public function get(Request $request) {
      $request->validate([
        'id' => 'required'
      ]);

      $nonBudgets = NonBudgets::where([
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
      $nonBudgets = new NonBudgets();
      $nonBudgets->file_number = $request->file_number;
      $nonBudgets->code_of_account = $request->code_of_account;
      $nonBudgets->activity = $request->activity;
      $nonBudgets->description = $request->description;
      $nonBudgets->amount = $request->amount;
      $nonBudgets->date = $date;
      $nonBudgets->save();

      return response()->json([
        'message' => 'Successfully saved non budget request.',
        'data' => $nonBudgets,
      ],200);
    }

    public function edit(Request $request) {
      $request->validate([
        'id' => 'required',
        'code_of_account' => 'required',
        'amount' => 'required',
        'activity' => 'required'
      ]);

      $nonBudgets = NonBudgets::where([
        ['id', '=', $request->id],
        ['submitted', '=', false]
      ])->first();

      if($nonBudgets) {
        $nonBudgets->file_number = $request->file_number;
        $nonBudgets->code_of_account = $request->code_of_account;
        $nonBudgets->activity = $request->activity;
        $nonBudgets->description = $request->description;
        $nonBudgets->amount = $request->amount;
        $nonBudgets->save();
        return response()->json([
          'message' => 'Successfully saved non budget request.',
          'data' => $nonBudgets
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

      $nonBudgets = NonBudgets::where([
        ['id', '=', $request->id]
      ]);

      if($nonBudgets) {
        if($nonBudgets->submitted == true) {
          return response()->json([
            'message' => 'The request has been submitted.'
          ],200);
        }
        else {
          $nonBudgets->submitted = true;
          $nonBudgets->save();
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

      $nonBudgets = NonBudgets::where([
        ['id', '=', $request->id],
        ['sumitted', '=', true]
      ]);

      if($nonBudgets) {
        $nonBudgets->submitted = $request->submitted;
        $nonBudgets->save();
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
