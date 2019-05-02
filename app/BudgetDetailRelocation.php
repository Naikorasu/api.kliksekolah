<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetDetailRelocation extends Model
{
    protected $fillable = [
      'source_unique_id',
      'destination_unique_id',
      'source_revised_amount',
      'source_original_amount',
      'destination_revised_amount',
      'source_revised_amount',
      'user_id'
    ];

    public function sourceBudgetDetail() {
      return $this->belongsTo('BudgetDetail', 'source_unique_id', 'unique_id');
    }

    public function destinationBudgetDetail() {
      return $this->belongsTo('BudgetDetail', 'destination_unique_id', 'unique_id');
    }
}
