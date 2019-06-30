<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Budgets;

class BudgetRelocations extends Model
{
    protected $fillable = [
      'user_id',
      'nomor_pengajuan',
      'approved',
      'submitted',
      'head',
      'account',
      'description'
    ];

    public function scopeTotalPengajuan($query) {
      return $query
            ->select(['*',
              DB::raw('total - (select IFNULL(SUM(relocated_amount),0) from budget_relocation_sources where budget_relocation_sources.budget_relocation_id = budget_relocations.id group by budget_relocation_id) as total')
            ]);
    }

    public function budgetRelocationSources() {
      return $this->hasMany(BudgetRelocationSources::class , 'budget_relocation_id', 'id');
    }

    public function budgetRelocationRecipients() {
      return $this->hasMany(BudgetRelocationRecipients::class , 'budget_relocation_id', 'id');
    }

    public function head() {
      return $this->belongsTo(Budgets::class, 'head', 'unique_id');
    }

}
