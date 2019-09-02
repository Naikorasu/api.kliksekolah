<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolUnits extends Model
{
    protected $table = 'prm_school_units';

    protected $fillable = [
      'name',
      'va_code',
      'unit_code',
      'prm_perwakilan_id'
    ];

    public function jouurnalCashBankDetails() {
      return $this->belongsTo('App\JournalCashBankDetails', 'unit_id', 'id');
    }

    public function user() {
      return $this->belongsTo('App\User', 'prm_school_units_id', 'id');
    }

    public function perwakilan() {
      return $this->belongsTo('App\Perwakilan', 'prm_perwakilan_id', 'id');
    }

    public function entity_unit(){
      return $this->belongsTo('App\EntityUnits', 'prm_school_units_id', 'id');
    }
}
