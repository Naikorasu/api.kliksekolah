<?php

namespace App\Services;

use Auth;

class ReportService extends BaseService {

  public function get($type, $from=null,$to=null){
    $conditions = [];
    $journals = Journals::with('journalDetails');

    if(isset($from)) {
      if(!isset($to)) {
        $to = date('Y-m-d');
      }
      $journals = $journals->whereBetween('date', [$from, $to])->get();
    } else {
      $journals = $journals->get();
    }

    return $journals;
  }
}
