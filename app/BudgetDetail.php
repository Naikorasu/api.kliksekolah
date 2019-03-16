<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetDetail extends Model
{
    //

    protected $table = 'budgets_detail';

    protected $fillable = [
        'unique_id',
        'head',
        'account',
        'code_of_account',
        'title',
        'quantity',
        'price',
        'term',
        'ypl',
        'committee',
        'intern',
        'bos',
        'total',
        'desc',
    ];

    public function account()
    {
        return $this->belongsTo(BudgetAccount::Class,'unique_id','account');
    }


}

