<?php

namespace App\Services;

use Auth;
use App\User;

class BaseService{

  protected $filterable = [];

  protected function getCurrentUser() {
    $user = User::with('userGroup')->find(Auth::user()->id);
    return $user;
  }

  protected function buildFilters($filters) {
    $conditions = [];
    if(isset($filters)) {
      if(isset($this->filterable)) {
        foreach($filters as $key => $value) {
          if(array_key_exists($key, $this->filterable)) {
            array_push($conditions, [$key, '=', $value]);
          }
        }
      } else {
        foreach($filters as $key => $value) {
          array_push($conditions, [$key, '=', $value]);
        }
      }
    }
    return $conditions;
  }
}
