<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BudgetDetail;

class BudgetRealization extends Model
{
    protected $table = 'budget_realization';

    protected $fillable = [
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
