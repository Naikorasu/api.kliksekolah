<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetDetailDraftRevisions extends Model
{
    protected $fillable = [
      'budget_detail_drafts_id',
      'user_groups_id',
      'field',
      'value'
    ];

    public function budgetDetailDraft() {
      return $this->belongsTo('App\BudgetDetailDrafts');
    }

    public function userGroup() {
      return $this->belongsTo('App\UserGroups');
    }
}
