<?php

namespace App\Services;

use Auth;

class ReportService extends BaseService {

  public function get($type, $from=null,$to=date('Y-m-d')){
    $conditions = [];
    $journals = Journals::with('journalDetails');

    if(isset($from)) {
      $journals = $journals->whereBetween('date', [$from, $to])->get();
    } else {
      $journals = $journals->get();
    }
    
    return $journals;
  }
}
