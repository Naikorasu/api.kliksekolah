<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\BudgetDraftRevisions;
use App\BudgetRelocationSources;
use Illuminate\Database\Eloquent\Builder;

class BudgetDetail extends Model
{
    //

    protected $table = 'budgets_detail';

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
    ];

    public function scopeParameterCode($query, $value=null, $type=null) {
      $query->with('parameter_code');
      if(isset($value)) {
        switch($type) {
          case 'group':
            return $query->whereHas(
              'parameter_code.group', function($q) use($value) {
                $q->where('code',$value);
              }
            );
            break;
          case 'category':
            return $query->whereHas(
              'parameter_code.group.category', function($q) use($value) {
                  $q->where('code', $value);
              }
            );
            break;
          case 'class':
            return $query->whereHas(
              'parameter_code.group.category.class', function($q) use($value) {
                $q->where('code', $value);
              }
            );
            break;
          default:
            return $query->whereHas(
              'parameter_code', function($q) use($value) {
                $q->where('code', $value);
              }
            );
            break;
        }
      }

      return $query;
    }

    public function scopeRAPBU($query) {
      return $query->where(function($q) {
        $q->where([
          ['code_of_account', 'like', '%4']
        ])->orWhere([
          ['code_of_account', 'like', '%5']
        ])->where('approved', true);
      });
    }

    public function scopeCodeOfAccountOptions($query) {
      return $query->with('parameter_code:code,title,group', 'parameter_code.group', 'parameter_code.group.category', 'parameter_code.group.category.class:code,title')->select(
                  DB::raw('distinct(code_of_account) as code_of_account')
            );
    }

    public function scopeRemains(Builder $query) {
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

    public function budgetRelocationSources() {
      return $this->hasMany(BudgetRelocationSources::class,'budget_detail_unique_id','unique_id');
    }

    public function budgetRelocationRecipients() {
      return $this->hasMany(BudgetRelocationRecipients::class,'budget_detail_unique_id','unique_id');
    }


}
