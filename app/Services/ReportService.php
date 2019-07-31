<?php

namespace App\Services;

use Auth;
use App\Journals;

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

  public function balance($filters) {
    $journals = Journals::with('journalDetails')->get();
  }
}
