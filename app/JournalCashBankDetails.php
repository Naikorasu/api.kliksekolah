<?php

namespace App;

use App\Journals;
use Illuminate\Database\Eloquent\Model;

class JournalCashBankDetails extends Model
{
    protected $fillable = [
      'journals_id',
      'reference_number',
      'counterparty',
      'tax_number',
      'tax_value',
      'gross_total',
      'tax_deduction',
      'nett_total'
    ];

    public function journal() {
      return $this->belongsTo(Journals::class);
    }
}
