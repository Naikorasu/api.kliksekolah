<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolUnits extends Model
{
    protected $table = 'prm_school_units';

    protected $fillable = [
      'name',
      'va_code',
      'unit_code'
    ];

    public function user() {
      return $this->belongsTo('App\User', 'prm_school_units_id', 'id');
    }

    public function entity_unit(){
      return $this->belongsTo('App\EntityUnits', 'prm_school_units_id', 'id');
    }
}
