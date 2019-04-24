<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'user_group';

    public function user() {
      return $this->belongsTo(User::class, 'group_id', 'id');
    }
}
