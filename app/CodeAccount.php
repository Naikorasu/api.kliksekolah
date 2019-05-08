<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BudgetDetail;

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
        return $this->belongsTo(BudgetDetail::Class,'code','code_of_account');
    }

    public function group()
    {
      return $this->belongsTo(CodeGroup::Class,'group', 'code');
    }
}
