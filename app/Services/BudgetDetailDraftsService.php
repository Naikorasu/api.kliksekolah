<?php

namespace App\Services;

use Auth;
use Illuminate\Database\QueryException;
use App\Services\WorkflowService;
use App\BudgetDetailDrafts;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\DataSaveFailureException;


class BudgetDetailDraftsService extends BaseService {

  public function saveBatch(array $budgetDetailDrafts, $head, $account) {
      foreach($budgetDetailDrafts as $draft) {
        $this->save($draft, $head, $account);
      }
  }

  public function save($budgetDetailDraft, $head, $account) {
    try {
      $budgetDetailDraft = BudgetDetailDrafts::updateOrCreate(array_merge(
        $budgetDetailDraft,
        [
            'user_id' => Auth::user()->id,
            'head' => $head,
            'account' => $account
        ]
      ));
    } catch(QueryException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function edit(array $budgetDetailDrafts, $head) {
    try {
      $budget = Budgets::where('unique_id', $head)->first();
    } catch (DataNotFoundException $exception) {
      return back()->withError($exception->getMessage(), $exception->getCode());
    }

    $user = User::with('userGroup')->find($budget->user_id);
    $workflow = WorkflowService::run($user, $budget->submitted, $budget->approved);

    if($workflow->createRevision) {

    }
  }

  public function submit() {

  }

  public function approve() {

  }

  public function reject() {

  }
}
