<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
  protected $fillable = [
    'entity',
    'entity_id',
    'name',
    'extension',
    'path',
    'size'
  ];

  public function entity() {
    return $this->morphTo();
  }
}
