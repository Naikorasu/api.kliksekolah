<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YoYBalance extends Model
{
    protected $table = 'yoy_balance';
    protected $fillable = [
      'year',
      'code_of_account',
      'value'
    ];
}
