<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityUnits extends Model
{
    protected $fillable = [
      'entity_type',
      'entity_id',
      'prm_school_units_id'
    ];

    public function entity() {
      return $this->morphTo();
    }

    public function school_unit() {
      return $this->belongsTo('App\SchoolUnits', 'prm_school_units_id', 'id');
    }
}
