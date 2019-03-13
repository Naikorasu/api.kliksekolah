<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeCategory extends Model
{
    //
    protected $table = 'prm_code_category';

    protected $fillable = [
        'class',
        'category',
        'title',
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
}
