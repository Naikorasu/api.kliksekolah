<?php

namespace App\Services;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\WorkflowService;
use App\BudgetDetailDraft;
use App\BudgetRealization;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\DataSaveFailureException;


class BudgetRealizationService extends BaseService {

  protected $filterable = [
    'head',
    'account',
    'title'
  ];

  public function list($filters) {
    $conditions = $this->buildFilters($filters);

    $budgetRealizations = BudgetRealization::with('budgetDetail.code_of_account')->where($conditions)->paginate(5);

    return $budgetRealizations;
  }

  public function get($id) {
    try {
      $budgetRealization = BudgetRealization::find($request->id);
      $budgetRealization->filename = '/storage/files/budget_realization_'.$budgetRealization->id.'_'.$budgetRealization->filename;
      return $budgetRealization;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function delete($id) {
    try{
      $budgetRealization = BudgetRealization::findOrFail($id);
      $budgetRealization->forceDelete();
      return true;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->message());
    }
  }

  public function save($budgetDetailUniqueId, $amount, $file, $description='', $id=null) {
      $file = $request->file('file');
      $fileName = $file->getClientOriginalName();

      $budgetRealization = BudgetRealization::updateOrCreate([
        'id' => $id,
        'budget_detail_unique_id' => $budgetDetailUniqueId,
        'filename' => $filename,
        'amount' => $amount,
        'description' => $description,
        'user_id' => Auth::user()->id,
      ]);


      $file->storeAs('public/files', 'budget_realization_'.$budgetRealization->id.'_'.$fileName);

      return $budgetRealization;
  }
}
