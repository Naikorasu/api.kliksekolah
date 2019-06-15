<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\JournalCashBankDetails;
use App\JournalDetails;

class Journals extends Model
{
    protected $fillable = [
      'journal_type',
      'date',
      'journal_number',
      'user_id'
    ];

    public function journalCashBankDetails() {
      return $this->hasOne(JournalCashBankDetails::class);
    }

    public function journalDetails() {
      return $this->hasMany(JournalDetails::class);
    }
}
