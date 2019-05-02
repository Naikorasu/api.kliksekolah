<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\BudgetRelocationSources;

class BudgetDetail extends Model
{
    //

    protected $table = 'budget_detail_drafts';

    //protected $primaryKey = 'unique_id';

    protected $fillable = [
        'unique_id',
        'head',
        'account',
        'semester',
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
        'user_id'
    ];

    /*
    public function account()
    {
        return $this->belongsTo(BudgetAccount::Class,'unique_id','account');
    }
    */

    public function scopeWithRemains($query) {
      return $query
              ->addSelect(array('*',
                DB::raw('total - (select SUM(amount) from fund_request where fund_request.budget_detail_unique_id = budgets_detail.unique_id and fund_request.is_approved=true group by budget_detail_unique_id) as remains')
              ));
    }

    public function parameter_code()
    {
        return $this->hasOne(CodeAccount::class,'code','code_of_account');
    }

    public function fundRequest() {
      return $this->hasMany(FundRequest::class, 'budget_detail_unique_id', 'unique_id');
    }

    public function revisions() {
      return $this->hasMany(BudgetRevisions::class, 'budget_detail_unique_id', 'unique_id');
    }

    public function budgetRelocationSources() {
      return $this->hasMany(BudgetRelocationSources::class,'budget_detail_unique_id','unique_id');
    }

    public function budgetRelocationRecipients() {
      return $this->hasMany(BudgetRelocationRecipients::class,'budget_detail_unique_id','unique_id');
    }


}
