<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BudgetDetails;

class BudgetRealizations extends Model
{
    protected $fillable = [
      'id',
      'budget_detail_unique_id',
      'filename',
      'amount',
      'description',
      'user_id'
    ];

    public function budgetDetail() {
      return $this->belongsTo(BudgetDetails::class, 'budget_detail_unique_id', 'unique_id');
    }
}
