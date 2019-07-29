<?php
namespace App\Services;

use Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\DataNotFoundException;
use App\JournalDetailAttributes;
use App\FundRequests;
use App\BudgetDetails;


class JournalRealizationService extends BaseService {

  public function list() {
    $journal = JournalDetailAttributes::with('journalDetails', 'journalDetails.journal', 'schoolUnit', 'fundRequest', 'fundRequest.budgetDetail')->get();

    return $journal;
  }
}
