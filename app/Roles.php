<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = [
      'name',
      'description'
    ];

    public function user_roles() {
      return $this->belongsTo(UserRoles::class);
    }
}
