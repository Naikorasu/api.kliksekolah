<?php
namespace App\Services;

use Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\DataNotFoundException;
use App\JournalCashBankDetails;
use App\FundRequests;
use App\BudgetDetails;


class JournalRealizationService extends BaseService {

  public function list() {
    $journal = JournalCashBankDetails::whereHas('fundRequest')->with('fundRequest', 'journalDetail', 'journalDetail.journal');

    return $journal;
  }
}
