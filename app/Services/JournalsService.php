<?php

namespace App\Services;

use Auth;
use DateTime;
use App\Journals;
use App\JournalCashBankDetails;
use App\JournalDetails;
use App\Exceptions\DataNotFoundException;
use App\JournalDetailAttributes;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JournalsService extends BaseService {

  public function save($data, $type) {

    $isCredit = false;

    if(isset($data->id)) {
      try {
        $journal = Journals::with('journalDetails')->where('journal_type',$type);
        if($type == 'KAS' || $type == 'BANK') {
          $journal = $journal->with('journalDetails.journalCashBankDetails')->findOrFail($data->id);
          $journal->journalDetails()->journalCashBankDetails()->forceDelete();
          $isCredit = $data->type == 'KAS_MASUK';
        } else if ($type == 'PEMBAYARAN') {
          $journal = $journal->with('journalPaymentDetails')->findOrFail($data->id);
          $journal->journalPaymentDetails()->forceDelete();
          $isCredit = true;
        } else {
          $journal = $journal->findOrFail($data->id);
        }
        $journal->journalDetails()->forceDelete();
      } catch (ModelNotFoundException $exception) {
        throw new DataNotFoundException($exception->message());
      }
    }

    if(!isset($journal)) {
      $journal = new Journals();
      $journal->journal_type = $type;
    }

    $journal->date = $data->date;
    $journal->journal_number = $data->journal_number;
    $journal->user_id = Auth::user()->id;
    $journal->accepted_by = $data->accepted_by;
    $journal->submitted_by = $data->submitted_by;
    $journal->save();

    if($type == 'PEMBAYARAN') {
      $this->saveJournalPaymentDetails($data, $journal);
    }

    foreach($data->details as $index => $detail) {
      $fields = (object) $detail;

      $journalDetail = new JournalDetails([
        'code_of_account' => $fields->code_of_account,
        'description' => $fields->description,
        'credit' => ($fields->credit) ? $fields->credit : ($isCredit) ? $fields->nominal : null,
        'debit' => ($fields->debit) ? $fields->debit : (!$isCredit) ? $fields->nominal : null,
        'journal_id' => $journal->id
      ]);

      $journalDetail->save();

      if($type == 'KAS' || $type == 'BANK') {
        $this->saveJournalCashBankDetails($data, $journalDetail);
      }
    }

    return $journal->load('journalPaymentDetails','journalDetails', 'journalDetails.journalCashBankDetails');
  }

  public function get($id, $type) {
    $journal = Journals::with('journalDetails');

    if($type == 'KAS' || $type == 'BANK') {
      $journal->with('journalDetails.journalCashBankDetails');
    } else if ($type == 'PEMBAYARAN') {
      $journal->with('journalPaymentDetails');
    }

    try {
      return $journal->findOrFail($id);;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->message());
    }
  }

  public function list($type) {
    $journal = Journals::where('journal_type', $type)->orderBy('date')->get();
    return $journal;
  }

  public function saveJournalCashBankDetails($data, $journalDetail) {
    $journalCashBankDetails = new JournalCashBankDetails(
      'unit_id' => $data->unit_id,
      'fund_requests_id' => $data->fund_requests_id,
      'tax_number' => $data->tax_number,
      'tax_value' => $data->tax_value
    );
    $journalDetail->journalCashBankDetails()->save($journalCashBankDetails);
  }

  public function saveJournalPaymentDetails($data, $journal) {
    $journalPaymentDetails = new JournalPaymentDetails([
      'va_code' => $data->va_code,
      'mmyy' => $data->mmyy
    ]);

    $journal->journalPaymentDetails()->save();
  }
}
