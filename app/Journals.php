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

    public function scopeCounter($query, $type, $isCredit, $month, $year) {
        return $query->
        where('journal_type', $type)->
        whereMonth('date', $month)->
        whereYear('date', $year)->
        whereHas('journalDetails', function($q) use($isCredit) {
          if($isCredit) {
            $q->where('credit', '<>', 'null');
          } else {
            $q->where('debit', '<>', 'null');
          }
        })->count();

    }

    public function journalPaymentDetails() {
      return $this->hasOne('App\JournalPaymentDetails');
    }

    public function journalDetails() {
      return $this->hasMany('App\JournalDetails', 'journals_id', 'id');
    }
}
