<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journals extends Model
{
    protected $fillable = [
      'journal_type',
      'date',
      'source',
      'journal_number',
      'accepted_by',
      'submitted_by',
      'is_posted',
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
        });

    }

    public function withTotalCredit($query) {
      return $query->withCount(['journalDetails as total' => function($q) {
        $q->select(DB::raw('SUM(credit) as total'));
      }]);
    }

    public function withTotalDebit($query) {
      return $query->withCount(['journalDetails as total' => function($q) {
        $q->select(DB::raw('SUM(debit) as total'));
      }]);
    }

    public function journalPaymentDetails() {
      return $this->hasOne('App\JournalPaymentDetails');
    }

    public function journalDetails() {
      return $this->hasMany('App\JournalDetails', 'journals_id', 'id');
    }

    public function school_unit() {
      return $this->morphMany('App\EntityUnits', 'entity');
    }

    public function user() {
      return $this->hasOne('App\User', 'id', 'user_id');
    }

}
