<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SchoolUnits;

class BudgetAccounts extends Model
{
    //protected $primaryKey = 'unique_id';

    protected $fillable = [
        'unique_id',
        'head',
        'account_type',
        'account_info',
        'prm_school_units_id'
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

    public function school_unit() {
      return $this->hasOne(SchoolUnits::class, 'prm_school_units_id', 'id');
    }

}
