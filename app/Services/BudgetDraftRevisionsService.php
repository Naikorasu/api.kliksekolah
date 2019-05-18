<?php

namespace App\Services;
use App\BudgetDraftRevisions;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\DataSaveFailureException;

class BudgetDraftRevisionsService extends BaseService {

  public function save($revisedValue, $fieldName, $draftId, $revisionId=null) {
    if($revisionId !== null) {
      try {
        $budgetDraftRevision = BudgetDraftRevisions::where([
          ['field_name', '=', $fieldName],
          ['id', '=', $revisionId]
        ])->first();
      } catch (DataNotFoundException $exception) {
        return back()->withError($exception->getMessage(), $exception->getCode());
      }
    } else {
      $budgetDraftRevision = new BudgetDraftRevisions();
      $budgetDraftRevision->budget_detail_draft_id = $draftId;
      $budgetDraftRevision->field_name = $fieldName;
      $budgetDraftRevision->user_id = $this->getCurrentUser()->id;
    }

    $budgetDraftRevision->revised_value = $revisedValue;

    try {
      return $budgetDraftRevision->save();
    } catch (DataSaveFailureException $exception) {
      return back()->withError($exception->getMessage(), $exception->getCode());
    }
  }

  public function get($revisionId) {
    try {
      $budgetDraftRevision = BudgetDraftRevisions::find($revisionId);
      return $budgetDraftRevision;
    } catch (DataNotFoundException $exception) {
      return back()->withError($exception->getMessage(), $exception->getCode());
    }
  }
}
