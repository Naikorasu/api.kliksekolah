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

    public function budgetDetail() {
      return $this->belongsTo(BudgetDetail::Class,'budget_detail_unique_id','unique_id');
    }
}
