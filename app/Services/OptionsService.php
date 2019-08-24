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

  public function getCodeOfAccounts($keyword = null, $withRealization = false, $codes = null, $categories = null, $groups = null, $classes = null) {
    try {
      if($withRealization == true) {
        $collection = CodeAccount::whereHas(
          'budgetDetail', function($q) {
              $q->whereHas('fundRequest', function($q) {
                $q->where('is_approved',true);
              });
          });
      } else {
        $collection = CodeAccount::whereNotNull('code');
      }

      if($codes) {
        $collection = CodeAccount::whereIn('code', $codes);
      }

      if(isset($keyword)){
        $collection->where(function($q) use($keyword) {
          $q->where('title','like','%'.$keyword.'%')->orWhere('code','like','%'.$keyword.'%');
        });
        //dd($collection->toSql());
      }

      $collection->whereHas(
        'group', function($q) use($categories, $groups, $classes) {
          if(isset($groups)) {
            $q->whereIn('code', $groups);
          }
          $q->whereHas(
            'category', function($q) use($categories, $classes) {
              if(isset($categories)) {
                $q->whereIn('code', $categories);
              }
              $q->whereHas(
                'class', function($q) use($classes) {
                  if(isset($classes)) {
                    $q->whereIn('code', $classes);
                  }
                }
              );
            }
          );
        }
      );

      return $collection->get();
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
    $conditions = [];
    if(isset($filters['periode'])) {
      $conditions = [
        ['periode', '=', $filters['periode']]
      ];
    }
    try {
      $collection = Budgets::options($keyword)->where($conditions)->get();

      return $collection->transform(function($item) {
        return [
          'id' => $item->id,
          'title' => $item->desc
        ];
      });
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
