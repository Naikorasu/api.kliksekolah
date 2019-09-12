<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalCashBankDetails extends Model
{
    protected $fillable = [
      'journal_details_id',
      'unit_id',
      'fund_requests_id',
      'journal_detail_type',
      'tax_type',
      'tax_value',
      'type',
      'npwp',
      'name',
      'bankAccount'
    ];

    public function journalDetail() {
      return $this->belongsTo('App\JournalDetails');
    }

    public function schoolUnit() {
      return $this->hasOne('App\SchoolUnits','id','unit_id');
    }

    public function fundRequest() {
      return $this->hasOne('App\FundRequests');
    }

    public function bankAccount() {
      return $this->hasOne('App\CodeAccount', 'bankAccount', 'code');
    }

    public function tax() {
      return $this->hasOne('App\Tax');
    }
}
