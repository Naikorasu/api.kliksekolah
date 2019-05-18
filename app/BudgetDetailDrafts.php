<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\BudgetDraftRevisions;

class BudgetDetailDrafts extends Model
{
    //protected $primaryKey = 'unique_id';

    protected $fillable = [
        'unique_id',
        'head',
        'account',
        'semester',
        'code_of_account',
        'title',
        'quantity',
        'price',
        'term',
        'ypl',
        'committee',
        'intern',
        'bos',
        'total',
        'desc',
        'user_id'
    ];

    public function parameter_code()
    {
        return $this->hasOne(CodeAccount::class,'code','code_of_account');
    }

    public function revisions() {
      return $this->hasMany(BudgetDraftRevisions::class , 'budget_detail_draft_id', 'id');
    }
}
