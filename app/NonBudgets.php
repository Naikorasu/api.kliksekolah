<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class NonBudgets extends Model {
  protected $fillable = [
    'file_number',
    'date',
    'code_of_account',
    'activity',
    'description',
    'amount',
    'filepath',
    'submitted',
    'is_approved',
    'user_id'
  ];

  public function scopeWithUnitId($query, $unit_id) {
    if(is_array($unit_id)) {
      return $query->whereHas('school_unit',function($q) use($unit_id) {
        $q->whereIn('prm_school_units_id', $unit_id);
      });
    }
    return $query->whereHas('school_unit', function($q) use($unit_id) {
      $q->where('prm_school_units_id', '=', $unit_id);
    });
  }

  public function parameter_code() {
      return $this->hasOne(CodeAccount::class,'code','code_of_account');
  }

  public function school_unit() {
    return $this->morphMany('App\EntityUnits', 'entity');
  }
}
