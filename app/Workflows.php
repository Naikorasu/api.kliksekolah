<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workflows extends Model
{
    protected $fillable = [
      'entity',
      'entity_id',
      'prev_role',
      'next_role',
      'is_done'
    ];

    public function entity() {
      return $this->morphTo();
    }
}
