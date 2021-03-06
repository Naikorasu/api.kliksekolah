<?php

namespace App\Services;

use Auth;
use App\JournalDetails;
use App\YoYBalance;
use App\CodeCategory;
use App\CodeAccount;
use App\CodeClass;
use App\Journals;
use Illuminate\Support\Facades\DB;



class ReportService extends BaseService {

  public function get($type, $from=null,$to=null){
    $data = [];
    $balance = 0;
    $journals = Journals::with('journalDetails')->orderBy('date','DESC');

    if($type == 'kas') {
      $journals->where('journal_type', 'KAS');
    } else if ($type == 'bank') {
      $journals->where('journal_type', 'BANK');
    }

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
              'date' => date('d-m-Y', strtotime($journal['date'])),
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

  public function monthly($codeGroup, $from = null, $to = null) {

    $dateFrom = 'DATE_FORMAT(journals.date, "%Y%m") >= "' .  (isset($from) ?  $from : date('Ym')) . '"';
    $dateTo = 'DATE_FORMAT(journals.date, "%Y%m") <= "' .  (isset($to) ?  $to : date('Ym')) . '"';

    $journalDetails = JournalDetails::with('journal')
      ->whereHas('journal', function($q) use($dateFrom, $dateTo) {
        $q->whereRaw($dateFrom)->whereRaw($dateTo);
      })->whereHas('parameter_code', function($q) use($codeGroup) {
        $q->where('group', $codeGroup);
      })->get();

    return $journalDetails->map(function($item) {
      return [
        'code_of_account' => $item['parameter_code'],
        'debit' => $item['debit'],
        'credit' => $item['credit']
      ];
    });
  }

  public function balance() {
    $categories = CodeClass::
    select(
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
    $dateFrom = '`journals`.`date` >= "' .  (isset($from) ?  $from : date('Y').'-01-01' ) . '"';
    $dateTo = '`journals`.`date` <= "' .  (isset($to) ?  $to : date('Y-m-d')) . '"';

    $incomes = CodeClass::where('code', '40000')
    ->select(
      DB::raw('`title`, `code`, `id`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
      LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
      LEFT JOIN `prm_code_group` on `prm_code_group`.`code` = `prm_code_account`.`group`
      LEFT JOIN `prm_code_category` on `prm_code_category`.`code` = `prm_code_group`.`category`
      WHERE `prm_code_category`.`class` = `prm_code_class`.`code` AND
      `journal_details`.`journals_id` IN (SELECT id FROM `journals` WHERE '. $dateFrom . ' AND ' . $dateTo. ')
      GROUP BY `prm_code_class`.`code`) as total'))
    ->with([
      'category' => function($q) use($dateFrom, $dateTo) {
        $q->select(DB::raw('`title`, `code`, `class`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
        LEFT JOIN `prm_code_group` on `prm_code_group`.`code` = `prm_code_account`.`group`
        WHERE `prm_code_group`.`category` = `prm_code_category`.`code` AND
        `journal_details`.`journals_id` IN (SELECT id FROM `journals` WHERE '. $dateFrom . ' AND ' . $dateTo. ')
        GROUP BY `prm_code_category`.`code`) as total'))
        ->orderBy('code');
      },
      'category.group' => function($q) use($dateFrom, $dateTo) {
        $q->select(DB::raw('`title`, `code`, `category`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
        WHERE `prm_code_account`.`group` = `prm_code_group`.`code` AND
        `journal_details`.`journals_id` IN (SELECT id FROM `journals` WHERE '. $dateFrom . ' AND ' . $dateTo. ')
        GROUP BY `prm_code_group`.`code`) as total'))
        ->orderBy('code');
      },
      'category.group.account' => function($q) use($dateFrom, $dateTo) {

        $q->select(DB::raw('`title`, `code`, `group`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        WHERE `journal_details`.`code_of_account` = `prm_code_account`.`code` AND
        `journal_details`.`journals_id` IN (SELECT id FROM `journals` WHERE '. $dateFrom . ' AND ' . $dateTo. ')
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
      WHERE `prm_code_category`.`class` = `prm_code_class`.`code` AND
      `journal_details`.`journals_id` IN (SELECT id FROM `journals` WHERE '. $dateFrom . ' AND ' . $dateTo. ')
      GROUP BY `prm_code_class`.`code`) as total'))
    ->with([
      'category' => function($q) use($dateFrom, $dateTo) {
        $q->select(DB::raw('`title`, `code`, `class`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
        LEFT JOIN `prm_code_group` on `prm_code_group`.`code` = `prm_code_account`.`group`
        WHERE `prm_code_group`.`category` = `prm_code_category`.`code` AND
        `journal_details`.`journals_id` IN (SELECT id FROM `journals` WHERE '. $dateFrom . ' AND ' . $dateTo. ')
        GROUP BY `prm_code_category`.`code`) as total'))
        ->orderBy('code');
      },
      'category.group' => function($q) use($dateFrom, $dateTo) {
        $q->select(DB::raw('`title`, `code`, `category`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        LEFT JOIN `prm_code_account` on `prm_code_account`.`code` = `journal_details`.`code_of_account`
        WHERE `prm_code_account`.`group` = `prm_code_group`.`code` AND
        `journal_details`.`journals_id` IN (SELECT id FROM `journals` WHERE '. $dateFrom . ' AND ' . $dateTo. ')
        GROUP BY `prm_code_group`.`code`) as total'))
        ->orderBy('code');
      },
      'category.group.account' => function($q) use($dateFrom, $dateTo) {
        $q->select(DB::raw('`title`, `code`, `group`, (SELECT SUM(credit) - SUM(debit) AS `amount` FROM `journal_details`
        WHERE `journal_details`.`code_of_account` = `prm_code_account`.`code` AND
        `journal_details`.`journals_id` IN (SELECT id FROM `journals` WHERE '. $dateFrom . ' AND ' . $dateTo. ')
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

  public function loadGeneralLedgerByAccount($account, $from = null, $to = null) {
    $items = JournalDetails::
      where('code_of_account',$account->code)
      ->whereHas('journal', function($q) use($from, $to) {
        if(isset($from)) {
          $q->where('date', '>=', date(strtotime($from), 'Y'));
        } else {
          $q->whereYear('date', '>=', date('Y'));
        }

        if(isset($to)) {
          $q->where('date', '<=', $to);
        }

        $q->where('is_posted', 1);
      })
      ->with('journal','parameter_code')->get();

    $cash = [
      'starting_balance' => 0,
      'debit' => 0,
      'credit' => 0,
      'final' => 0
    ];

    $bank = [
      'starting_balance' => 0,
      'debit' => 0,
      'credit' => 0,
      'final' => 0
    ];

    foreach($items as $item) {
      if($item->journal->source == 'KAS') {
        $cash['debit'] += floatval($item->debit);
        $cash['credit'] += floatval($item->credit);
      } else {
        $bank['debit'] += floatval($item->debit);
        $bank['credit'] += floatval($item->credit);
      }
    };

    $cash['final'] = $cash['credit'] - $cash['debit'];
    $bank['final'] = $bank['credit'] - $bank['debit'];

    return [
      'account_code' => $account->code,
      'account_title' => $account->title,
      'account_type' => $account->type,
      'cash' => $cash,
      'bank' => $bank
    ];
  }

  public function generalLedger($code_of_account = null, $from = null, $to = null) {
    $data = [];

    if(isset($code_of_account)) {
      $accounts = CodeAccount::where('code', $code_of_account)->get();
    } else {
      $accounts = CodeAccount::get();
    }

    foreach($accounts as $account) {
      array_push($data, $this->loadGeneralLedgerByAccount($account, $from, $to));
    }

    return $data;
  }
}
