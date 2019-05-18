<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetAccounts extends Model
{
    //protected $primaryKey = 'unique_id';

    protected $fillable = [
        'unique_id',
        'head',
        'account_type',
        'account_info',
    ];


    /*
    public function detail()
    {
        return $this->hasMany(BudgetDetails::Class,'account','unique_id');
    }
    */

    public function budget()
    {
        return $this->belongsTo(Budgets::Class,'unique_id','head');
    }

}
