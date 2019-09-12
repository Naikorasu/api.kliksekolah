<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxFields extends Model
{
    protected $fillable = [
      'tax_id',
      'field_name',
      'value'
    ];

    public function tax() {
      return $this->belongsTo('App\Tax');
    }
}
