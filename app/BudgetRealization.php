<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BudgetDetail;

class BudgetRealization extends Model
{
    private $fillable = [
      'budget_detail_unique_id',
      'filename',
      'amount',
      'description',
      'user_id'
    ];

    public function budgetDetail() {
      return $this->belongsTo(BudgetDetail::class, 'budget_detail_unique_id', 'unique_id');
    }
}
