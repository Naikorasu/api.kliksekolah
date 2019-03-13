<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeGroup extends Model
{
    //
    protected $table = 'prm_code_group';

    protected $fillable = [
        'code',
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

    public function account()
    {
        return $this->hasMany(CodeAccount::Class, 'group', 'code');;
    }

    public function category()
    {
        return $this->belongsTo(CodeCategory::Class,'code');
    }
}
