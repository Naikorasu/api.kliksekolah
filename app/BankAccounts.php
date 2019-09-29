<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccounts extends Model
{
    protected $fillable = [
      'code_of_account',
      'account_number',
      'address',
      'city'
      'swift_code'
    ];

    public function parameter_code() {
      return $this->hasOne('App\CodeAccount', 'code_of_account', 'code');
    }

    public function schoolUnit() {
      return $this->morphTo( [$name, $type, $id, $ownerKey]);
    }
}
