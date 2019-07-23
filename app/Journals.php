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
        where('MONTH(date)', $month)->
        where('YEAR(date)', $year)->
        whereHas('journalDetails', function(Builder $query) use($isCredit) {
          if($isCredit) {
            $query->where('credit', '<>', 'null');
          } else {
            $query->where('debit', '<>', 'null');
          }
        })->count();

    }

    public function journalPaymentDetails() {
      return $this->hasOne('App\JournalPaymentDetails');
    }

    public function journalDetails() {
      return $this->hasMany('App\JournalDetails', 'journal_id', 'id');
    }
}
