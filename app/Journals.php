<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journals extends Model
{
    protected $fillable = [
      'journal_type',
      'date',
      'journal_number',
      'accepted_by',
      'submitted_by',
      'user_id'
    ];

    public function journalPaymentDetails() {
      return $this->hasOne('App\JournalPaymentDetails');
    }

    public function journalDetails() {
      return $this->hasMany('App\JournalDetails', 'journal_id', 'id');
    }
}
