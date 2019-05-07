<?php

namespace App\Services;

use Auth;
use App\Services\WorkflowService;
use App\BudgetDetailDraft;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\DataSaveFailureException;


class BudgetDetailDraftService extends BaseService {

  public function add(array $budgetDetailDrafts, $head, $account) {
      foreach($budgetDetailDrafts as $draft) {
        try {
          $budgetDetailDraft = new BudgetDetailDraft($draft);
          $budgetDetailDraft->save();
        }
        catch (DataSaveFailureException $exception) {
          return back()->withError($exception->getMessage(), $exception->getCode());
        }
      }
  }

  public function edit(array $budgetDetailDrafts, $head) {
    try {
      $budget = Budget::where('unique_id', $head)->first();
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
