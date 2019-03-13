<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeAccount extends Model
{
    //
    protected $table = 'prm_code_account';

    protected $fillable = [
        'code',
        'group',
        'title',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function group()
    {
        return $this->belongsTo(CodeGroup::Class,'code');
    }
}
