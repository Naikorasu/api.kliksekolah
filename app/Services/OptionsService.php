<?php

namespace App\Services;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\DataNotFoundException;
use App\CodeAccount;
use App\SchoolUnits;
use App\FundRequests;
use App\CodeClass;

use App\BudgetDetails;
use App\Budgets;

class OptionsService extends BaseService {

  //add code of account for budgetrequest, budget approval
  //Realisasi harus tarik dari budget detail yang sudah ada budget Request

  public function getCodeOfAccounts($filters, $withRealization = false, $codes = null, $categories = null, $groups = null, $classes = null) {
    $conditions = $this->buildFilters($filters);
    try {
      if($withRealization == true) {
        $collection = CodeClass::options()->whereHas(
          'category.group.account.budgetDetail', function($q) {
              $q->whereHas('fundRequest', function($q) {
                $q->where('is_approved',true);
              });
          });
      } else {
        $collection = CodeClass::options();
      }

      $collection->with(
        ['category' => function($q) use($categories, $groups, $codes) {
          if(isset($categories)) {
            $q->whereIn('code', $categories);
          }
          $q->with(
            ['group' => function($q) use($groups, $codes) {
              if(isset($groups)) {
                $q->whereIn('code', $groups);
              }
              $q->with(
                ['account' => function($q) use($codes) {
                  if(isset($codes)) {
                    $q->whereIn('code', $codes);
                  }
                }]
              );
            }]
          );
        }]
      );

      if(isset($classes)) {
        if(is_array($classes)) {
          $collection->whereIn('code', $classes);
        } else {
          $collection->where('code', 'like', $classes.'%');
        }
      }

      return $collection->where($conditions)->get();
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function getPeriodes($filters, $withRealization = false) {
    $conditions = $this->buildFilters($filters);

    try {
      $collection = Budgets::periodeOptions()->where($conditions)->get();

      $options = [];
      foreach($collection as $option) {
        array_push($options, [
          "id" => $option->periode,
          "title" => $option->periode
        ]);
      }
      return $options;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function getFundRequests($filters) {
    $conditions = $this->buildFilters($filters);

    try {
      $collection = FundRequests::options()->where($conditions)->get();

      $options = [];
      foreach($collection as $option) {
        array_push($options, [
          "id" => $option->periode,
          "title" => $option->periode
        ]);
      }
      return $options;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function getBudgets($filters, $keyword = '') {
    $conditions = $this->buildFilters($filters);
    try {
      $collection = Budgets::options($keyword)->where($conditions)->get();

      $options = [];
      foreach($collection as $option) {
        array_push($options, [
          "id" => $option->id,
          "title" => $option->desc
        ]);
      }
      return $options;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function getPph($filters) {
    $conditions = $this->buildFilters($filters);

    try {
      $collection = CodeAccount::where('title', 'like', 'PPH%')
      ->where($conditions)->get();

      $options = [];
      foreach($collection as $option) {
        array_push($options, [
          "id" => $option->id,
          "title" => $option->title
        ]);
      }
      return $options;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function getUnit($filters) {
    $conditions = $this->buildFilters($filters);

    try {
      $collection = SchoolUnits::where($conditions)->get();

      $options = [];
      foreach($collection as $option) {
        array_push($options, [
          "id" => $option->id,
          "title" => $option->title
        ]);
      }
      return $options;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }

  }
}
