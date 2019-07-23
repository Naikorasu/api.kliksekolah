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
    $journalNumber = '';

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
      $journal->journalNumber = $this->generateJournalNumber($type, $isCredit, $data->date);
    }

    $journal->date = $data->date;
    $journal->journal_number = $journalNumber;
    $journal->user_id = Auth::user()->id;
    $journal->accepted_by = $data->accepted_by;
    $journal->submitted_by = $data->submitted_by;
    $journal->save();

    if($type == 'PEMBAYARAN') {
      $this->saveJournalPaymentDetails($data, $journal);

    }

    if($type == 'KAS' || $type == 'BANK') {
      foreach($data->details['standard'] as $index => $detail) {
        $fields = (object) $detail;
        $journalDetail = $this->saveJournalDetail($journal, $fields, $isCredit);
        $this->saveJournalCashBankDetails($data, $journalDetail);
      }

      foreach($data->details['reconciliation'] as $index => $detail) {
        $fields = (object) $detail;
        $journalDetail = $this->saveJournalDetail($journal, $fields, $isCredit);
        $this->saveJournalCashBankDetails($data, $journalDetail);
      }
    } else {
      foreach($data->details as $index => $detail) {
        $fields = (object) $detail;
        $this->saveJournalDetail($journal, $fields, $isCredit);
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

  public function saveJournalDetail($journal, $fields, $isCredit) {
    $journalDetail = new JournalDetails([
      'code_of_account' => (isset($fields->code_of_account)) ? $fields->code_of_account : null,
      'description' => (isset($fields->description)) ? $fields->description : '',
      'credit' => (isset($fields->credit)) ? $fields->credit : ($isCredit) ? $fields->nominal : null,
      'debit' => (isset($fields->debit)) ? $fields->debit : (!$isCredit) ? $fields->nominal : null,
      'journals_id' => $journal->id
    ]);

    $journalDetail->save();
    return $journalDetail;
  }

  public function saveJournalCashBankDetails($data, $journalDetail) {
    $journalCashBankDetails = new JournalCashBankDetails(
      ['unit_id' => $data->unit_id,
      'fund_requests_id' => $data->fund_requests_id,
      'tax_number' => $data->tax_number,
      'tax_value' => $data->tax_value]
    );
    $journalDetail->journalCashBankDetails()->save($journalCashBankDetails);
  }

  public function saveJournalPaymentDetails($data, $journal) {
    $va_code = $data->va_code;

    $journalPaymentDetails = new JournalPaymentDetails([
      'payment_type' => $data->payment_type,
      'va_code' => $data->va_code,
      'mmyy' => $data->mmyy
    ]);

    $journal->journalPaymentDetails->save($journalPaymentDetails);
  }

  private function generateJournalNumber($type, $isCredit, $date) {
    $unit = Auth::user()->schoolUnit();
    $d = date_parse_from_format("Y-m-d", $date);
    $month = $d['month'];
    $year = $d['year'];
    $counter = str_pad(Journals::counter($type, $isCredit,$month, $year) + 1, 3,'0',STR_PAD_LEFT);
    $code = '';
    switch($type) {
      case 'KAS':
        $code = 'BK';
        break;
      case 'BANK':
        $code = 'BB';
        break;
      case 'UMUM':
        $code = 'BU';
        break;
      case 'PEMBAYARAN':
        $code = 'BP';
        break;
      case 'PENYESUAIAN':
        $code = 'BN';
        break;
      default:
        $code = '';
    }

    if($isCredit) {
      $code = $code.'M';
    } else {
      $code = $code.'K';
    }

    if(!isset($unit)) {
      $unit = '000';
    }

    $journalNumber = $code.str_pad($year, 3, '0', STR_PAD_LEFT).$counter.$unit;
    return $journalNumber;
  }
}
