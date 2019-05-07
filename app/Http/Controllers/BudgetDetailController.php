<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BudgetDetailService;

class BudgetDetailController extends Controller
{

  private $budgetDetailService;

  public function __construct(BudgetDetailService $budgetDetailService) {
    $this->budgetDetailService = $budgetDetailService;
  }

  public function list_detail(Request $request)
  {
      $results = $this->budgetDetailService->getList($request->filters);
      return response()->json([
          'message' => 'Load Data Detail Success',
          'data' => $results,
      ], 200);
  }



  public function list_detail_rapbu(Request $request)
  {
      $request->validate([
          'filters.head' => 'required'
      ]);

      $filters = [
        "head" => $request->head_unique_id
      ];

      $data = $this->budgetDetailService->getRAPBUList($filters);

      return response()->json([
          'message' => 'Load Data Detail All Success',
          'data' => $data,
      ], 200);
  }

  public function add_detail(Request $request)
  {
      $request->validate([
          'head' => 'required',
          'account' => 'required',
          'account_type' => 'required|integer'
      ]);

      $data = $this->budgetDetailService->save(json_decode($request->data, true), $request->head, $request->account, $request->account_type);

      // $process_data = json_decode($request->data, true);
      //
      // $unique_id_head = $request->head_unique_id;
      // $unique_id_account = $request->account_unique_id;
      // $account_type = $request->account_type;
      //
      // foreach ($process_data as $key => $val) {
      //
      //     $semester = $val['semester'];
      //     $code_of_account = $val['coa'];
      //     $title = $val['title'];
      //     $quantity = $val['quantity'];
      //     $price = $val['price'];
      //     $term = $val['term'];
      //     $ypl = $val['ypl'];
      //     $committee = $val['committee'];
      //     $intern = $val['intern'];
      //     $bos = $val['bos'];
      //     $total = $val['total'];
      //     $desc = $val['desc'];
      //
      //     //$fh = New FunctionHelper();
      //     //$unique_id_detail = $fh::generate_unique_key($user_email . ";" . "DETAIL" . ";" . $account_type . ";" . $code_of_account . ";");
      //
      //     $data = array(
      //         //'unique_id' => $unique_id_detail,
      //         'head' => $unique_id_head,
      //         'account' => $unique_id_account,
      //         'semester' => $semester,
      //         'code_of_account' => $code_of_account,
      //         'title' => $title,
      //         'quantity' => $quantity,
      //         'price' => $price,
      //         'term' => $term,
      //         'ypl' => $ypl,
      //         'committee' => $committee,
      //         'intern' => $intern,
      //         'bos' => $bos,
      //         'total' => $total,
      //         'desc' => $desc,
      //     );
      //
      //     //$budget_detail = New BudgetDetail($data);
      //     $budget_detail_draft = New BudgetDetailDraft($data);
      //   //  $budget_detail_draft->save();
      // }
      //
      //
      // if ($budget_detail_draft) {
      //     return response()->json([
      //         'message' => 'Successfully Add Budget Row Detail',
      //         'data' => $budget_detail_draft
      //     ], 200);
      // } else {
      //     return response()->json([
      //         'message' => 'Failed Add Budget Row Detail',
      //         'error' => $budget_detail_draft,
      //     ], 200);
      // }
      return response()->json([
          'message' => 'Succesfully added budget detail',
          'data' => $data
      ],200);
  }

  public function edit_detail(Request $request)
  {
      $request->validate([
          'head_unique_id' => 'required',
          'account_unique_id' => 'required',
          'account_type' => 'required|integer',
          'data' => 'required',
      ]);

      $process_data = json_decode($request->data, true);

      $budgetHead = Budget::find($unique_id_head);

      $workflowResult = $this->runWorkflow('SAVE', $budgetHead);

      foreach ($process_data as $key => $val) {

          $unique_id_detail = $val['unique_id'];

          $update_data = array(
              'code_of_account' => $val['coa'],
              'title' => $val['title'],
              'quantity' => $val['quantity'],
              'price' => $val['price'],
              'term' => $val['term'],
              'ypl' => $val['ypl'],
              'committee' => $val['committee'],
              'intern' => $val['intern'],
              'bos' => $val['bos'],
              'total' => $val['total'],
              'desc' => $val['desc'],
              'updated_at' => date('Y-m-d H:i:s'),
          );

          $budgetDetail = BudgetDetail::where('unique_id', $unique_id_detail)->first();

          if($workflowResult->createRevision){
            $budgetRevision = new BudgetRevisions();
            $budgetRevision->budget_detail_unique_id = $unique_id_detail;
            $budgetRevision->original_values = json_encode($budgetDetail);
            $budgetRevision->revised_values = json_encode($update_data);
            $budgetRevision->user_id = Auth::user()->id;
            $budgetRevision->save();
          } else {
            $budgetRevision = $budgetDetail->update($update_data);
          }

          if ($budgetRevision) {
              return response()->json([
                  'message' => 'Successfully Update Budget Row Detail',
                  'result' => $budgetRevision,
              ], 200);

          } else {

              return response()->json([
                  'message' => 'Failed Update Budget Row Detail',
                  'error' => $budgetRevision,
              ], 401);
          }
      }
  }

  public function delete_detail(Request $request)
  {
      $user = $request->user();
      $user_email = $user->email;

      $request->validate([
          'detail_unique_id' => 'required',
      ]);

      $delete = BudgetDetail::where('unique_id', $request->detail_unique_id)->delete();

      if ($delete) {
          return response()->json([
              'message' => 'Successfully Delete Budget Row Detail',
              'result' => $delete,
          ], 200);

      } else {

          return response()->json([
              'message' => 'Failed Delete Budget Row Detail',
              'error' => $delete,
          ], 401);
      }

  }
}
