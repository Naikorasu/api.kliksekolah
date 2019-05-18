<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetDraftRevisions extends Model
{
    protected $fillable = [
      'budget_detail_draft_id',
      'field_name',
      'revised_value',
      'user_id'
    ];

    public function budgetDetailDraft() {
      $this->belongsTo(BudgetDetailDrafts::class,'budget_detail_draft_id','id');
    }
}
