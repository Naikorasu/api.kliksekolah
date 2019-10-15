<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
      'entity',
      'entity_id',
      'value',
      'user_id'
    ];

    public function entity() {
      return $this->morphTo();
    }
}
