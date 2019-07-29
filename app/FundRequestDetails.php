<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FundRequests;

class FundRequestDetails extends Model
{
    protected $fillable = [
      'fund_request_id',
      'budget_detail_unique_id',
      'amount'
    ];

    public function fund_request() {
      return $this->belongsTo(FundRequests::class, 'fund_request_id', 'id');
    }

    public function budgetDetail() {
      return $this->belongsTo(BudgetDetails::Class,'budget_detail_unique_id','id');
    }
}
