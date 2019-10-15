<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\FundRequestDetails;

class FundRequests extends Model
{
    protected $table = 'fund_requests';

    protected $fillable = [
      'budget_detail_unique_id',
      'amount',
      'head',
      'periode',
      'is_approved',
      'submitted',
      'user_id'
    ];

    public function $workflowRoles = [
      'Keuangan Sekolah',
      'Kepala Sekolah',
      'Korektor Perwakilan',
      'Ketua Perwakilan'
    ];
    /**
     * Scope for status (submitted and/or approved)
     * @param  Builder $query      the current query being used
     * @param  boolean $approved   approved status
     * @param  boolean $submitted  submitted status
     * @return Builder             returns the updated query
     */
    public function scopeStatus($query, $approved, $submitted) {
      $query->where([
        ['is_approved', '=', $approved],
        ['submitted', '=', $submitted]
      ]);
    }

    public function scopeWithUnitId($query, $unit_id) {
      if(is_array($unit_id)) {
        return $query->whereHas('school_unit', function($q) use($unit_id) {
          $q->whereIn('prm_school_units_id', $unit_id);
        });
      }
      return $query->whereHas('school_unit', function($q) use($unit_id) {
        $q->where('prm_school_units_id', '=', $unit_id);
      });
    }

    public function scopeOptions($query) {
      return $query->select(DB::raw('distinct id'));
    }

    public function scopeTotalAmount($query) {
      return $query->withCount(['fundRequestDetails as amount' => function($q) {
        $q->select(DB::raw('SUM(amount) as total_amount'));
      }]);
    }

    public function head() {
      return $this->belongsTo('App\Budgets', 'head', 'id');
    }

    public function budgetDetail() {
      return $this->belongsTo(BudgetDetails::Class,'budget_detail_unique_id','unique_id');
    }

    public function fundRequestDetails() {
      return $this->hasMany(FundRequestDetails::class, 'fund_request_id', 'id');
    }

    public function school_unit() {
      return $this->morphOne('App\EntityUnits', 'entity');
    }

    public function workflow() {
      return $this->morphOne('App\Workflows', 'entity');
    }

    public function journalCashBankDetails() {
      return $this->belongsTo('App\JournalCashBankDetails', 'fund_requests_id', 'id');
    }
}
