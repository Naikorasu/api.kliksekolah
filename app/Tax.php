<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'tax';

    protected $fillable = [
      'journal_cash_bank_details_id',
      'type',
      'recipient',
      'tax_deduction'
    ];

    public function journalCashBankDetail() {
      return $this->belongsTo('App\JournalCashBankDetails');
    }

    public function taxFields() {
      return $this->hasMany('App\TaxFields');
    }
}
