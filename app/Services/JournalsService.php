<?php

namespace App\Services;

use Auth;
use DateTime;
use App\Journals;
use App\JournalCashBankDetails;
use App\JournalPaymentDetails;
use App\JournalDetails;
use App\User;
use App\Exceptions\DataNotFoundException;
use App\CodeAccount;
use App\EntityUnits;
use App\SchoolUnits;
use App\JournalDetailAttributes;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JournalsService extends BaseService {

  public function save($data, $type) {

    $isCredit = false;
    $journalNumber = '';
    $receivedBy = (isset($data->received_by)) ? $data->received_by : '';
    $submittedBy = (isset($data->submitted_by)) ? $data->submitted_by : '';

    if(isset($data->id)) {
      try {
        $journal = Journals::with('journalDetails')->where('journal_type',$type);
        if($type == 'KAS' || $type == 'BANK') {
          $journal = $journal->with('journalDetails.journalCashBankDetails')->findOrFail($data->id);

          foreach($journal->journalDetails as $journalDetail) {
            $journalDetail->journalCashBankDetails()->forceDelete();
          }

          $isCredit = $data->type == 'KAS_MASUK' || $data->type == 'BANK_MASUK';

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
    if($type == 'KAS' || $type == 'BANK') {
      $isCredit = $data->type == 'KAS_MASUK' || $data->type == 'BANK_MASUK';
    }

    if(!isset($journal)) {
      $journal = new Journals();
      $journal->journal_type = $type;
      $journal->journal_number = $this->generateJournalNumber($type, $isCredit, $data->date);
      $journal->accepted_by = $receivedBy;
      $journal->submitted_by = $submittedBy;
    }

    $journal->date = $data->date;
    $journal->user_id = Auth::user()->id;
    $journal->accepted_by = $receivedBy;
    $journal->submitted_by = $submittedBy;
    $journal->save();

    if($type == 'PEMBAYARAN') {
      $this->saveJournalPaymentDetails($data, $journal);

    }
    if($type == 'KAS' || $type == 'BANK') {
      foreach($data->details['standard'] as $index => $detail) {
        $fields = (object) $detail;
        $journalDetail = $this->saveJournalDetail($journal, $fields, $isCredit);
        $this->saveJournalCashBankDetails($fields, $journalDetail, $data->type, 'standard');
      }

      foreach($data->details['reconciliation'] as $index => $detail) {
        $fields = (object) $detail;
        $journalDetail = $this->saveJournalDetail($journal, $fields, $isCredit);
        $this->saveJournalCashBankDetails($data, $journalDetail, $data->type, 'reconciliation');
      }
    } else if($type == 'PEMBAYARAN') {
      $coa = '41301';
      switch ($data->payment_type) {
        case 'Uang Sekolah':
          $coa = '41301';
          break;
        case 'Uang Komputer':
          $coa = '41401';
          break;
        case 'Uang POMG':
          $coa = '41601';
          break;
        case 'Uang Kegiatan':
          $coa = '41501';
          break;
        case 'DPP':
          $coa = '41101';
          break;
        case 'UPP':
          $coa = '41201';
          break;
        case 'Seragam':
          $coa = '42102';
          break;
        case 'Uang Kegiatan (non Rutin)':
          $coa = '41501';
          break;
        default:
          break;
       }
       $journal->journalPaymentDetails()->save( new JournalPaymentDetails([
           'mmyy' => $data->mmyy,
           'payment_va_code' => $data->va_code,
           'payment_type' => $data->payment_type
         ])
       );

       $journal->journalDetails()->save(new JournalDetails([
          'code_of_account' => $coa,
          'description' => $data->payment_type,
          'credit' => $data->nominal
       ]));

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
    $data = [];
    try {
      if($type == 'KAS' || $type == 'BANK') {
        $data = $journal->with('journalDetails.journalCashBankDetails', 'journalDetails.journalCashBankDetails.schoolUnit')->findOrFail($id)->toJson();
        $data = json_decode($data);
        $data->details = [
          'standard' => [],
          'reconciliation' => []
        ];

        foreach($data->journal_details as $index => $detail) {
          $journalCashBankDetails = $detail->journal_cash_bank_details;
          if(isset($journalCashBankDetails->type)) {
            $data->type = $journalCashBankDetails->type;
          }
          if($journalCashBankDetails->journal_detail_type == 'reconciliation') {
            array_push($data->details['reconciliation'], [
                'code_of_account' => $detail->code_of_account,
                'nominal' => (isset($detail->credit)) ? $detail->credit : $detail->debit,
                'tax_type' => null,
                'tax_value' => null,
                'unit_id' => $journalCashBankDetails->unit_id,
                'parameter_code' => $detail->parameter_code,
                'description' => $detail->description
            ]);
          } else {
            array_push($data->details['standard'], [
                'code_of_account' => $detail->code_of_account,
                'nominal' => (isset($detail->credit)) ? $detail->credit : $detail->debit,
                'tax_type' => $journalCashBankDetails->tax_type,
                'tax_value' => $journalCashBankDetails->tax_value,
                'npwp' => $journalCashBankDetails->npwp,
                'name' => $journalCashBankDetails->name,
                'parameter_code' => $detail->parameter_code,
                'description' => $detail->description
            ]);
          }
        }
        if($data->details['standard'].length > 0) {
          $data->tipe = 'standard';
        } else {
          $data->tipe = 'rekonsiliasi';
        }
      } else if ($type == 'PEMBAYARAN') {
        $journal = $journal->with('journalPaymentDetails')->findOrFail($id);
        $journal->details = $journal->journalDetails;
        $journal->mmyy = $journal->journalPaymentDetails->mmyy;
        $journal->payment_type = $journal->journalPaymentDetails->payment_type;
        $journal->payment_va_code = $journal->journalPaymentDetails->payment_va_code;
        return $journal;
      } else {
        $journal = $journal->findOrFail($id);
        $journal->details = $journal->journalDetails;

        return $journal;
      }
       return $data;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->message());
    }
  }

  public function list($type) {
    if($type != 'KAS' && $type != 'BANK') {
      $journals = JournalDetails::join('journals', 'journals.id', '=', 'journal_details.journals_id')
      ->orderBy('journals.date', 'DESC')->where('journals.journal_type',$type)->get();
      $journals = $journals->transform(function($journal) {
        $accountName = '';
        if(isset($journal->code_of_account)) {
          $coa = CodeAccount::where('code',$journal->code_of_account)->first();
          if(isset($coa)) {
            $accountName = $coa->title;
          }
        }
        return [
          'id' => $journal->journals_id,
          'debet' => $journal->debit,
          'credit' => $journal->credit,
          'date' => $journal->journal->date,
          'description' => $journal->description,
          'account' => $accountName,
          'journal_number' => $journal->code_of_account,
          'type' => $journal->journal->journal_type
        ];
      });
      return [
        "data" => $journals
      ];
    } else {
      $journals = Journals::where('journal_type', $type)->with('journalDetails')->orderBy('date', 'DESC')->paginate(5);
      return $journals;
    }

  }

  public function saveJournalDetail($journal, $fields, $isCredit) {
    $credit = null;
    $debit = null;
    if(property_exists($fields, 'nominal')) {
      if($isCredit) {
        $credit = $fields->nominal;
      } else {
        $debit = $fields->nominal;
      }
    } else {
      $credit = isset($fields->credit) ? $fields->credit : null;
      $debit = isset($fields->debit) ? $fields->debit : null;
    }
    $accountName = '';
    if(isset($fields->code_of_account)) {
      $coa = CodeAccount::where('code',$fields->code_of_account)->first();
      if(isset($coa)) {
        $accountName = $coa->title;
      }
    }

    $journalDetail = new JournalDetails([
      'code_of_account' => (isset($fields->code_of_account)) ? $fields->code_of_account : null,
      'description' => (isset($fields->description)) ? $fields->description : '',
      'name' => $accountName,
      'credit' => $credit,
      'debit' => $debit,
      'journals_id' => $journal->id
    ]);

    $journalDetail->save();
    return $journalDetail;
  }

  public function saveJournalCashBankDetails($data, $journalDetail, $type, $journal_detail_type) {
    $journalCashBankDetails = new JournalCashBankDetails(
      [
        'unit_id' => isset($data->unit_id) ? $data->unit_id : null,
        'journal_detail_type' => $journal_detail_type,
        'fund_requests_id' => isset($data->fund_request_id) ? $data->fund_request_id : null,
        'tax_number' => isset($data->tax_number) ? $data->tax_number :null,
        'tax_value' => isset($data->tax_value) ? $data->tax_value : null,
        'npwp' => isset($data->npwp) ? $data->npwp : null,
        'type' => $type
      ]
    );
    $journalDetail->journalCashBankDetails()->save($journalCashBankDetails);
  }

  public function saveJournalPaymentDetails($data, $journal) {
    $va_code = $data->va_code;

    $journalPaymentDetails = new JournalPaymentDetails([
      'payment_type' => $data->payment_type,
      'payment_va_code' => $data->va_code,
      'mmyy' => $data->mmyy
    ]);

    $journal->journalPaymentDetails()->save($journalPaymentDetails);
  }

  private function generateJournalNumber($type, $isCredit, $date) {
    $unit = Auth::user()->schoolUnit['unit_code'];
    $unitCode = '000';
    if(isset($unit)) {
      $unitCode = $unit;
    }
    $month = date('m', strtotime($date));
    $year = date('y', strtotime($date));
    $counter = str_pad(strval(Journals::counter($type, $isCredit,$month, date('Y', strtotime($date)))->get()->count() + 1), 3,'0',STR_PAD_LEFT);
    $code = '';

    switch($type) {
      case 'KAS':
        $code = 'BK';
        break;
      case 'BANK':
        $code = 'BB';
        break;
      case 'UMUM':
        $code = 'UM';
        break;
      case 'PEMBAYARAN':
        $code = 'PB';
        break;
      case 'PENYESUAIAN':
        $code = 'PN';
        break;
      default:
        $code = 'NK';
    }

    if($isCredit) {
      $code = $code.'M';
    } else {
      $code = $code.'K';
    }

    if(!isset($unit)) {
      $unit = '000';
    }

    $journalNumber = $code.$year.$month.str_pad($counter, 2, '0', STR_PAD_LEFT).$unitCode;
    return $journalNumber;
  }

  public function delete($id) {
    $journal = Journals::findOrFail($id);
    $journal->delete();
    return $journal;
  }

  public function preview($id, $type) {
    $journal = Journals::where('journal_type', $type)->with('journalDetails', 'user');
    if($type == 'KAS' || $type == 'BANK'){
      $journal = $journal->with('journalDetails.journalCashBankDetails','school_unit.school_unit')->findOrFail($id);
      $entityUnit = EntityUnits::where('entity_type', 'App\Journals')->find($journal->id);
      $unit = null;
      if(isset($entityUnit)) {
        $unit = SchoolUnits::find($entityUnit->unit_id);
      }

      $isCredit = $journal->journalDetails[0]->journalCashBankDetails->type == 'KAS_MASUK' || $journal->journalDetails[0]->journalCashBankDetails->type == 'BANK_MASUK';

      $total = 0;
      $details = [];

      if(isset($journal->journalDetails)) {
        foreach($journal->journalDetails as $detail) {
          array_push($details, [
            'code_of_account' => $detail->code_of_account,
            'amount' => (isset($detail->credit)) ? $detail->credit : $detail->debit,
            'parameter_code' => $detail->parameter_code,
            'description' => $detail->description
          ]);

          if($detail->credit) {
            $total = $total + $detail->credit;
          } else {
            $total = $total + $detail->debit;
          }
        }
      }

      return [
        'date' => $journal->date,
        'journal_type' => $journal->journal_type,
        'journal_number' => $journal->journal_number,
        'accepted_by' => $journal->accepted_by,
        'submitted_by' => $journal->submitted_by,
        'booked_by' => (isset($journal->user)) ? $journal->user->name : '(                   )',
        'title' => $journal->description,
        'total' => $total,
        'details' => $details,
        'isCredit' => $isCredit,
        'unit' => [
          'name' => (isset($unit)) ? $unit->name : 'PUSAT',
          'address' => ''
        ]
      ];
    }
  }

  public function postJournal($id) {
    $journal = Journals::find($id);
    $journal->is_posted = true;
    $journal->save();
    return $journal;
  }
}
