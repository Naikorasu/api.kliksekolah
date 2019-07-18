<?php

namespace App\Services;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\WorkflowService;
use App\BudgetDetailDrafts;
use App\BudgetRealizations;
use App\Exceptions\DataNotFoundException;
use App\Exceptions\DataSaveFailureException;

/**
 * [BudgetRealizationsService description]
 * 1. Data:
 *    a. APBU
 *    b. Jurnal Kas
 *    c. Jurnal Bank
 * 2. Input Jurnal Kas & Bank -> Realisasi
 */

class BudgetRealizationsService extends BaseService {

  protected $filterable = [
    'head',
    'account',
    'title'
  ];

  public function list($filters) {
    $conditions = $this->buildFilters($filters);

    $budgetRealizations = BudgetRealizations::with('budgetDetail')->where($conditions)->paginate(5);

    return $budgetRealizations;
  }

  public function get($id) {
    try {
      $budgetRealization = BudgetRealizations::find($request->id);
      $budgetRealization->filename = '/storage/files/budget_realization_'.$budgetRealization->id.'_'.$budgetRealization->filename;
      return $budgetRealization;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function delete($id) {
    try{
      $budgetRealization = BudgetRealizations::findOrFail($id);
      $budgetRealization->forceDelete();
      return true;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->message());
    }
  }

  public function save($budgetDetailUniqueId, $amount, $file, $description='', $id=null) {
      $fileName = $file->getClientOriginalName();

      $budgetRealization = BudgetRealizations::updateOrCreate(
        ['id' => $id],
        [
          'budget_detail_unique_id' => $budgetDetailUniqueId,
          'filename' => $fileName,
          'amount' => $amount,
          'description' => $description,
          'user_id' => Auth::user()->id
      ]);


      $file->storeAs('public/files', 'budget_realization_'.$budgetRealization->id.'_'.$fileName);

      return $budgetRealization;
  }
}
