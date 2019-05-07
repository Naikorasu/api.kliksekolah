<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Psy\CodeCleaner;

class CodeClass extends Model
{
    //

    protected $table = 'prm_code_class';

    protected $fillable = [
        'code',
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

    public function category()
    {
        return $this->hasMany(CodeCategory::Class, 'code');
    }

}
