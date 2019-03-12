<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetDetail extends Model
{
    //

    protected $table = 'budgets_detail';

    protected $fillable = [
        'header',
        'coa',
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

    public function BudgetDetail()
    {
        return $this->belongsTo('App\Budget');
    }
}

