<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

  protected $table = 'file';
  
  protected $fillable = [
    'entity',
    'entity_id',
    'name',
    'extension',
    'path',
    'display_name',
    'size'
  ];

  public function entity() {
    return $this->morphTo();
  }
}
