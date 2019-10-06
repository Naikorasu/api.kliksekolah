<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perwakilan extends Model
{
    protected $table = 'prm_perwakilan';

    protected $fillable = [
      'code',
      'name'
    ];

    public function users() {
      return $this->belongsTo('App\User', 'prm_perwakilan_id');
    }

    public function schoolUnits() {
      return $this->hasMany('App\SchoolUnits', 'prm_perwakilan_id', 'id');
    }
}
