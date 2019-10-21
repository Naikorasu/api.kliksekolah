<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Budgets;
use App\BudgetRelocationSources;
use Illuminate\Database\Eloquent\Builder;

class BudgetDetails extends Model
{

    //protected $primaryKey = 'unique_id';
    protected $table = 'budget_details';

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
        'recommendation_bos',
        'recommendation_ypl',
        'recommendation_intern',
        'recommendation_committee',
        'budget_detail_drafts_id'
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
          ['code_of_account', 'like', '4%']
        ])->orWhere([
          ['code_of_account', 'like', '5%']
        ])->orWhere([
            ['code_of_account', 'like', '13%']
        ]);

      })->with([
        'head' => function($query) {
            $query->where('approved', false);
        }
      ]);
    }

    public function scopeCodeOfAccountOptions($query) {
      return $query->with('parameter_code:code,title,group', 'parameter_code.group', 'parameter_code.group.category', 'parameter_code.group.category.class:code,title')->select(
                  DB::raw('distinct(code_of_account) as code_of_account')
            );
    }

    public function scopeRemains($query) {
      return $query
              ->select(['*',
                DB::raw('total - (select IFNULL(SUM(amount),0) from fund_requests where fund_requests.budget_detail_unique_id = budget_details.unique_id and fund_requests.is_approved=true group by budget_detail_unique_id) as remains')
              ]);
    }

    public function parameter_code()
    {
        return $this->hasOne(CodeAccount::class,'code','code_of_account');
    }

    public function head() {
      return $this->belongsTo(Budgets::class, 'head', 'unique_id');
    }

    public function fundRequest() {
      return $this->hasMany(FundRequests::class, 'budget_detail_unique_id', 'unique_id');
    }

    public function budgetRelocationSources() {
      return $this->hasMany(BudgetRelocationSources::class,'budget_detail_unique_id','unique_id');
    }

    public function budgetRelocationRecipients() {
      return $this->hasMany(BudgetRelocationRecipients::class,'budget_detail_unique_id','unique_id');
    }

    public function budgetDetailDraft() {
      return $this->hasOne('App\BudgetDetailDrafts', 'unique_id', 'unique_id');
    }

    public function recommendations() {
      return $this->hasOneThrough(
        'App\BudgetDetailDraftRevisions',
        'App\BudgetDetailDrafts',
        'unique_id',
        'budget_detail_drafts_id',
        'unique_id',
        'unique_id'
      );
    }

    public function file() {
      return $this->hasOneThrough(
        'App\File',
        'App\BudgetDetailDrafts',
        'unique_id',
        'entity_id',
        'unique_id',
        'unique_id'
       );
    }

}
