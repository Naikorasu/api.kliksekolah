<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class Budget extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'budgets';

    //protected $primaryKey = 'unique_id';

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

    public function scopeWithRevisionCount(Builder $query) {
      return $query->addSelect(
          DB::raw('(select count(id) from budget_revisions where budget_revisions.budget_detail_unique_id in (select unique_id from budgets_detail where budgets_detail.head = budgets.unique_id)) as revision_count')
        );
    }

    public function account()
    {
        return $this->hasMany(BudgetAccount::Class,'head','unique_id');
    }
}
