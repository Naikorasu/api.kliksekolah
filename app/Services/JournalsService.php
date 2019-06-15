<?php

namespace App\Services;

use Auth;
use DateTime;
use App\Journals;
use App\JournalCashBankDetails;
use App\JournalDetails;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JournalsService extends BaseService {

  public function save($data, $type) {
    $isCashBank = $type == 'KAS' || $type == 'BANK';

    if(isset($data->id)) {
      try {
        if($isCashBank) {
          $journal = Journals::with('journalDetails')->with('journalCashBankDetails')->where('journal_type',$type)->findOrFail($data->id);
        } else {
          $journal = Journals::with('journalDetails')->where('journal_type',$type)->findOrFail($data->id);
        }
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
    $journal->save();

    if($isCashBank) {
      $journalCashBankDetails = JournalCashBankDetails::updateOrCreate([
        'journals_id' => $journal->id
      ], [
        'reference_number' => $data->reference_number,
        'counterparty' => $data->counterparty,
        'tax_number' => $data->tax_number,
        'tax_value' => $data->tax_value
      ]);
    }

    foreach($data->details as $index => $detail) {
      $fields = (object) $detail;
      if($isCashBank) {
        $fields->code_of_account = $data->code_of_account;
        if($data->type == 'KAS_MASUK') {
          $fields->credit = $fields->nominal;
        } else {
          $fields->debit = $fields->nominal;
        }
      }

      $id = (isset($fields->id)) ? $fields->id : null;

      $journalDetails = JournalDetails::updateOrCreate([
        'id' => $id,
        'journals_id' => $journal->id
      ], (array) $fields);
    }

    return $journal->load('journalCashBankDetails','journalDetails');
  }

  public function get($id, $type) {
    $isCashBank = $type == 'KAS' || $type == 'BANK';

    $journal = Journals::with('journalDetails');

    if($isCashBank) {
      $journal->with('journalCashBankDetails');
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
}
