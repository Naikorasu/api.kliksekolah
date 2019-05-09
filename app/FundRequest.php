<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FundRequest extends Model
{
    //

    protected $table = 'fund_request';

    protected $fillable = [
      'budget_detail_unique_id',
      'amount',
      'is_approved',
      'submitted',
      'user_id'
    ];

    /**
     * Scope for status (submitted and/or approved)
     * @param  Builder $query      the current query being used
     * @param  boolean $approved   approved status
     * @param  boolean $submitted  submitted status
     * @return Builder             returns the updated query
     */
    public function scopeStatus($query, $approved, $submitted) {
      $query->where([
        ['is_approved', '=', $approved],
        ['submitted', '=', $submitted]
      ]);
    }

/**
 * [budgetDetail description]
 * @return [type] [description]
 */
    public function budgetDetail() {
      return $this->belongsTo(BudgetDetail::Class,'budget_detail_unique_id','unique_id');
    }
}
