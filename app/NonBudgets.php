<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class NonBudgets extends Model {
  protected $fillable = [
    'file_number',
    'date',
    'code_of_account',
    'activity',
    'description',
    'amount',
    'filepath',
    'submitted',
    'is_approved',
    'user_id'
  ];

  public function parameter_code() {
      return $this->hasOne(CodeAccount::class,'code','code_of_account');
  }
}
