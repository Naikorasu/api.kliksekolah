<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetAccount extends Model
{
    //

    protected $table = 'budgets_account';

    protected $fillable = [
        'unique_id',
        'head',
        'account_type',
        'account_info',
    ];

    public function detail()
    {
        return $this->hasMany(BudgetDetail::Class,'account','unique_id');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::Class,'unique_id','head');
    }
}
