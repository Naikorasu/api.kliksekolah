<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetRelocation extends Model
{
    protected $table = 'budget_relocation';
    
    protected $fillable = [
      'user_id',
      'approved',
      'submitted'
    ];

    public function budgetRelocationSources() {
      return $this->hasMany(BudgetRelocationSources::class , 'budget_relocation_id', 'id');
    }

    public function budgetRelocationRecipients() {
      return $this->hasMany(BudgetRelocationRecipients::class , 'budget_relocation_id', 'id');
    }
}
