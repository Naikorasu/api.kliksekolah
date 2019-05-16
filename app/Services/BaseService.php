<?php

namespace App\Services;

use Auth;
use App\Classes\FunctionHelper;
use App\User;

class BaseService{

  protected $filterable = [];
  protected $fh;

  public function __construct(FunctionHelper $fh) {
    $this->fh = $fh;
  }

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

  protected function generateUniqueId($accountType, $code_of_account) {
    $user = Auth::user();
    $user_email = $user->email;
    return $this->fh::generate_unique_key($user_email . ";" . "DETAIL" . ";" . $accountType . ";" . $code_of_account . ";");
  }
}
