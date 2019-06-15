<?php

namespace App;

use App\Scopes\ParameterCodeScope;
use Illuminate\Database\Eloquent\Model;

class JournalDetails extends Model
{
    protected $fillable =[
      'id',
      'journals_id',
      'code_of_account',
      'description',
      'debit',
      'credit'
    ];

    protected static function boot() {
        parent::boot();

        static::addGlobalScope(new ParameterCodeScope);
    }

    public function journal() {
      return $this->belongsTo(Journals::class);
    }

    public function parameter_code()
    {
        return $this->hasOne(CodeAccount::class,'code','code_of_account');
    }
}
