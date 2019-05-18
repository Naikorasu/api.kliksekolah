<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetRelocationSources extends Model
{
    protected $fillable = [
      'budget_relocation_id',
      'budget_detail_unique_id',
      'relocated_amount',
      'description'
    ];

    public function budgetDetail() {
      return $this->belongsTo(BudgetDetails::class, 'budget_detail_unique_id','unique_id');
    }

    public function budgetRelocation() {
      return $this->belongsTo(BudgetRelocations::class, 'id', 'budget_relocation_id');
    }
}
