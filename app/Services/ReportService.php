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
    select(
      DB::raw('`title`, `code`, `id`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
      LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
      LEFT JOIN `prm_code_group` on `prm_code_group`.`code` = `prm_code_account`.`group`
      WHERE `prm_code_group`.`category` = `prm_code_category`.`code`
      GROUP BY `prm_code_category`.`code`) as total'))
    ->with([
      'group' => function($q) {
        $q->select(DB::raw('`title`, `code`, `category`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
        WHERE `prm_code_account`.`group` = `prm_code_group`.`code`
        GROUP BY `prm_code_group`.`code`) as total'))
        ->orderBy('code');
      },
      'group.account' => function($q) {
        $q->select(DB::raw('`title`, `code`, `group`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        WHERE `journal_details`.`code_of_account` = `prm_code_account`.`code`
        GROUP BY `journal_details`.`code_of_account`) as total'))
        ->orderBy('code');
      }
    ])->orderBy('code')->get();


    $totalGlobal = 0;
    foreach($categories as $category) {
      if(isset($category->total)) {
        $totalGlobal += $category->total;
      }
    }

    return [
      'code_categories' => $categories,
      'total' => $totalGlobal
    ];
  }

  public function profitLoss($from = null, $to = null) {
    $incomes = CodeClass::where('code', '40000')
    ->select(
      DB::raw('`title`, `code`, `id`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
      LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
      LEFT JOIN `prm_code_group` on `prm_code_group`.`code` = `prm_code_account`.`group`
      LEFT JOIN `prm_code_category` on `prm_code_category`.`code` = `prm_code_group`.`category`
      WHERE `prm_code_category`.`class` = `prm_code_class`.`code`
      GROUP BY `prm_code_class`.`code`) as total'))
    ->with([
      'category' => function($q) {
        $q->select(DB::raw('`title`, `code`, `class`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
        LEFT JOIN `prm_code_group` on `prm_code_group`.`code` = `prm_code_account`.`group`
        WHERE `prm_code_group`.`category` = `prm_code_category`.`code`
        GROUP BY `prm_code_category`.`code`) as total'))
        ->orderBy('code');
      },
      'category.group' => function($q) {
        $q->select(DB::raw('`title`, `code`, `category`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
        WHERE `prm_code_account`.`group` = `prm_code_group`.`code`
        GROUP BY `prm_code_group`.`code`) as total'))
        ->orderBy('code');
      },
      'category.group.account' => function($q) {
        $q->select(DB::raw('`title`, `code`, `group`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        WHERE `journal_details`.`code_of_account` = `prm_code_account`.`code`
        GROUP BY `journal_details`.`code_of_account`) as total'))
        ->orderBy('code');
      }
    ])->orderBy('code')->get();



    $expenses = CodeClass::where('code', '50000')
    ->select(
      DB::raw('`title`, `code`, `id`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
      LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
      LEFT JOIN `prm_code_group` on `prm_code_group`.`code` = `prm_code_account`.`group`
      LEFT JOIN `prm_code_category` on `prm_code_category`.`code` = `prm_code_group`.`category`
      WHERE `prm_code_category`.`class` = `prm_code_class`.`code`
      GROUP BY `prm_code_class`.`code`) as total'))
    ->with([
      'category' => function($q) {
        $q->select(DB::raw('`title`, `code`, `class`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
        LEFT JOIN `prm_code_group` on `prm_code_group`.`code` = `prm_code_account`.`group`
        WHERE `prm_code_group`.`category` = `prm_code_category`.`code`
        GROUP BY `prm_code_category`.`code`) as total'))
        ->orderBy('code');
      },
      'category.group' => function($q) {
        $q->select(DB::raw('`title`, `code`, `category`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
        WHERE `prm_code_account`.`group` = `prm_code_group`.`code`
        GROUP BY `prm_code_group`.`code`) as total'))
        ->orderBy('code');
      },
      'category.group.account' => function($q) {
        $q->select(DB::raw('`title`, `code`, `group`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        WHERE `journal_details`.`code_of_account` = `prm_code_account`.`code`
        GROUP BY `journal_details`.`code_of_account`) as total'))
        ->orderBy('code');
      }
    ])->orderBy('code')->get();

    $totalIncome = 0;
    $totalExpense = 0;
    $profitLoss = 0;

    foreach($incomes as $income) {
      if(isset($income->total)) {
        $totalIncome += $income->total;
      }
    }

    foreach($expenses as $expense) {
      if(isset($expense->total)) {
        $totalExpense += $expense->total;
      }
    }

    $profitLoss = $totalIncome - $totalExpense;

    return [
      "pendapatan" => $incomes,
      "pengeluaran" => $expenses,
      "total_pendapatan" => $totalIncome,
      "total_pengeluaran" => $totalExpense,
      "laba_rugi" => $profitLoss
    ];
  }

}
