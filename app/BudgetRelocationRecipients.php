<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetRelocationRecipients extends Model
{
  protected $fillable = [
    'budget_relocation_id',
    'budget_detail_id',
    'allocated_amount',
    'description',
    'is_draft'
  ];

  public function budgetDetailDraft() {
    return $this->belongsTo(BudgetDetailDraft::class, 'budget_detail_id', 'id');
  }

  public function budgetDetail() {
    return $this->belongsTo(BudgetDetail::class, 'budget_detail_id','unique_id');
  }

  public function budgetRelocation() {
    return $this->belongsTo(BudgetRelocation::class, 'id', 'budget_relocation_id');
  }
}
