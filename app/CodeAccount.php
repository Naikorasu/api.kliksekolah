<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BudgetDetails;
use App\JournalDetails;

class CodeAccount extends Model
{
    //
    protected $table = 'prm_code_account';

    protected $fillable = [
        'code',
        'group',
        'title',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function budgetDetail() {
        return $this->belongsTo(BudgetDetails::class,'code','code_of_account');
    }

    public function journalDetail() {
      return $this->belongsTo(JournalDetails::class, 'code', 'code_of_account');
    }

    public function group()
    {
      return $this->belongsTo(CodeGroup::Class,'group', 'code');
    }
}
