<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $fillable = [
      'user_id',
      'roles_id'
    ];

    public function user() {
      return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function role() {
      return $this->belongsTo(Roles::class, 'roles_id', 'id');
    }
}
