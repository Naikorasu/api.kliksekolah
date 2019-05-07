<?php

namespace App\Services;

use Auth;
use App\User;

class BaseService{

  public function getCurrentUser() {
    $user = User::with('userGroup')->find(Auth::user()->id);
    return $user;
  }

  public function buildFilters($filters) {
    $conditions = [];
    if(isset($filters)) {
      foreach($filters as $key => $value) {
        array_push($conditions, [$key, '=', $value]);
      }
    }
    return $conditions;
  }
}
