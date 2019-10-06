<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Budgets extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $primaryKey = 'unique_id';
    //
    protected $fillable = [
        'unique_id',
        'periode',
        'create_by',
        'desc'
    ];

    public function scopePeriodeOptions($query) {
      return $query->select(DB::raw('distinct(periode) as periode'));
    }

    public function scopeWithRevisionCount($query) {
      return $query->addSelect(
          DB::raw('(select count(id) from budget_revisions where budget_revisions.budget_detail_unique_id in (select unique_id from budgets_detail where budgets_detail.head = budgets.unique_id)) as revision_count')
        );
    }

    public function scopeWithUnitId($query, $unit_id) {
      if(is_array($unit_id)) {
        return $query->whereHas('school_unit',function($q) use($unit_id) {
          $q->whereIn('prm_school_units_id', $unit_id);
        });
      }
      return $query->whereHas('school_unit', function($q) use($unit_id) {
        $q->where('prm_school_units_id', '=', $unit_id);
      });
    }

    public function scopeOptions($query, $keyword) {
      return $query->select('id','desc')->where([
        ['desc', 'like', '%'.$keyword.'%']
      ]);
    }

    public function account()
    {
        return $this->hasMany('App\BudgetAccounts','head','unique_id');
    }

    public function budgetDetails() {
        return $this->hasMany('App\BudgetDetails', 'head', 'unique_id');
    }

    public function fundRequest() {
      return $this->hasMany('App\FundRequests', 'head', 'id');
    }

    public function school_unit() {
      return $this->morphMany('App\EntityUnits', 'entity');
    }

    public function workflow() {
      return $this->morphOne('App\Workflows', 'entity');
    }
}
