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
}
