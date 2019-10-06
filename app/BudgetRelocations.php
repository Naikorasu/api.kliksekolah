<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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


    public function scopeWithUnitId($query, $unit_id) {
      if(is_array($unit_id)) {
        return $query->whereHas('school_unit',function($q) use($unit_id) {
          $q->whereIn('prm_school_units_id', $unit_id);
        });
      }
      return $query->whereHas('school_unit', function($q) use($unit_id) {
        $q->where('prm_school_units_id', '=', $unit_id);
      });
    }
    
    public function scopeTotalPengajuan($query) {
      return $query
            ->select(['*',
              DB::raw('(select IFNULL(SUM(relocated_amount),0) from budget_relocation_sources where budget_relocation_sources.budget_relocation_id = budget_relocations.id group by budget_relocation_id) as total')
            ]);
    }

    public function budgetRelocationSources() {
      return $this->hasMany(BudgetRelocationSources::class , 'budget_relocation_id', 'id');
    }

    public function budgetRelocationRecipients() {
      return $this->hasMany(BudgetRelocationRecipients::class , 'budget_relocation_id', 'id');
    }

    public function head() {
      return $this->belongsTo(Budgets::class, 'head', 'id');
    }

    public function school_unit() {
      return $this->morphOne('App\EntityUnits', 'entity');
    }

    public function workflow() {
      return $this->morphOne('App\Workflows', 'entity');
    }
}
