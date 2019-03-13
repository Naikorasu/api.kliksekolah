<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeCategory extends Model
{
    //
    protected $table = 'prm_code_category';

    protected $fillable = [
        'code',
        'class',
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

    public function group()
    {
        return $this->hasMany(CodeGroup::Class, 'category', 'code');;
    }

    public function class()
    {
        return $this->belongsTo(CodeClass::Class,'code');
    }

    /*
    public function groupAccount()
    {
        return $this->hasManyThrough(
            CodeAccount::Class,
            CodeGroup::Class,
            'category', // Foreign key on groups table...
            'group', // Foreign key on accounts table...
            'code', // Local key on category table...
            'code' // Local key on groups table...
        );
    }
    */

}
