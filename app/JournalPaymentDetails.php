<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalPaymentDetails extends Model
{

  protected $fillable = [
    'journals_id',
    'payment_va_code',
    'mmyy',
  ];

  public function journal() {
    return $this->belongsTo('App\Journals');
  }
}
