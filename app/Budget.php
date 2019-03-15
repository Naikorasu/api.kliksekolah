<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Budget extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'budgets';

    protected $fillable = [
        'unique_id',
        'periode',
        'create_by',
        'desc',
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
        return $this->hasMany(BudgetAccount::Class,'head','unique_id');
    }
}
