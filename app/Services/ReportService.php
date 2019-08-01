<?php

namespace App\Services;

use Auth;
use App\CodeCategory;
use App\CodeAccount;
use App\CodeClass;
use App\Journals;
use Illuminate\Support\Facades\DB;



class ReportService extends BaseService {

  public function get($type, $from=null,$to=null){
    $data = [];
    $balance = 0;
    $journals = Journals::with('journalDetails');

    if(isset($from)) {
      if(!isset($to)) {
        $to = date('Y-m-d');
      }
      $journals = $journals->whereBetween('date', [$from, $to])->get()->toArray();
    } else {
      $journals = $journals->get()->toArray();
    }
    if(isset($journals)) {
      foreach($journals as $index => $journal) {
        if(isset($journal['journal_details'])) {

          foreach($journal['journal_details'] as $detail) {
            $isCredit = false;
            $nbm = '';
            $nbk = '';
            if(isset($detail['credit'])) {
              $balance += floatval($detail['credit']);
              $isCredit = true;
              $nbm = $journal['journal_number'];
            }
            if(isset($detail['debit'])) {
              $balance += floatval($detail['debit']);
              $nbk = $journal['journal_number'];
            }

            array_push($data, [
              'journal_number' => $journal['journal_number'],
              'date' => $journal['date'],
              'nbm' => $nbm,
              'nbk' => $nbk,
              'credit' => $detail['credit'],
              'debit' => $detail['debit'],
              'description' => $detail['description'],
              'balance' => number_format($balance, 2, ',', '.'),
              'parameter_code' => $detail['parameter_code'],
              'isCredit' => $isCredit
            ]);
          }
        }
      }
    }


    return [
      'data' => $journals,
      'formatted' => $data
    ];
  }

  public function balance() {
    $categories = CodeCategory::
    with([
      'group' => function($q) {
        $q->orderBy('code');
      },
      'group.account' => function($q) {
        $q->select(DB::raw('`title`, `code`, `group`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details` WHERE `journal_details`.`code_of_account` = `prm_code_account`.`code` GROUP BY `journal_details`.`code_of_account`) as amount'));

      }
    ])->orderBy('code')->get();

    $totalGlobal = 0;
    foreach($categories as $category) {
      $categoryTotal = 0;
      foreach($category->group as $group) {
        if(isset($group->account)) {
          $groupTotal = 0;
          foreach($group->account as $account) {
            if(isset($account->amount)) {
              $groupTotal += $account->amount;
            }
          }
        }
        $group->total = $groupTotal;
        $categoryTotal += $groupTotal;
      }
      $category->total = $categoryTotal;
      $totalGlobal += $categoryTotal;
    }

    return [
      'total' => $totalGlobal,
      'code_categories' => $categories,
    ];
  }
}
