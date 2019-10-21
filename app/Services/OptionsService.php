<?php

namespace App\Services;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\DataNotFoundException;
use App\CodeAccount;
use App\SchoolUnits;
use App\FundRequests;
use App\CodeClass;
use App\CodeGroup;

use App\BudgetDetails;
use App\Budgets;

class OptionsService extends BaseService {

  //add code of account for budgetrequest, budget approval
  //Realisasi harus tarik dari budget detail yang sudah ada budget Request

  public function getCodeOfAccounts($keyword = null, $withRealization = false, $codes = null, $categories = null, $groups = null, $classes = null, $excludes = array()) {
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

      $collection->where('code', '!=', '12902');

      if(isset($keyword)){
        $collection->where(function($q) use($keyword) {
          $q->where('title','like','%'.$keyword.'%')->orWhere('code','like','%'.$keyword.'%');
        });
      }

      if(array_key_exists('codes', $excludes) && isset($excludes['codes'])) {
        $collection->whereNotIn('code',$excludes['codes']);
      }

      $collection->whereHas(
        'group', function($q) use($categories, $groups, $classes, $excludes) {
          if(isset($groups)) {
            $q->whereIn('code', $groups);
          }
          if(array_key_exists('groups', $excludes) && isset($excludes['groups'])) {
            $q->whereNotIn('code',$excludes['groups']);
          }
          $q->whereHas(
            'category', function($q) use($categories, $classes, $excludes) {
              if(isset($categories)) {
                $q->whereIn('code', $categories);
              }
              if(array_key_exists('categories', $excludes) && isset($excludes['categories'])) {
                $q->whereNotIn('code',$excludes['categories']);
              }
              $q->whereHas(
                'class', function($q) use($classes, $excludes) {
                  if(isset($classes)) {
                    $q->whereIn('code', $classes);
                  }
                  if(array_key_exists('classes', $excludes) && isset($excludes['classes'])) {
                    $q->whereNotIn('code',$excludes['classes']);
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

  public function getBankAccounts($keyword) {
    $bankAccount = CodeAccount::whereIn('group',[11200, 11300, 11400])->where('code', '!=', '12902');
    if(isset($keyword)) {
      $bankAccount->where(function($q) use($keyword) {
        $q->where('title', 'like', '%'.$keyword.'%');
        $q->orWhere('code', 'like', '%'.$keyword.'%');
      });
    }
    return $bankAccount->get();
  }


  public function getRAPBUCoa($head, $keyword = null) {
    $budget = Budgets::select('unique_id')->find($head);

    $coa = CodeAccount::whereHas('budgetDetail', function($q) use($budget) {
      $q->where('head', $budget['unique_id']);
    })->where('code', '!=', '12902')->where('code', 'not like', '4%');

    if(isset($keyword)) {
      $coa->where('code', 'like', '%'.$keyword.'%');
      $coa->orWhere('title', 'like', '%'.$keyword.'%');
    }

    return $coa->get();
  }

  public function getCodeGroup($keyword = null) {
    if(isset($keyword)) {
      $codeGroups = CodeGroup::whereLike('title', '%'.$keyword.'%');
    }
    $codeGroups = CodeGroup::get();
    return $codeGroups->map(function($item) {
      return [
        'label' => $item['code'] .' - '. $item['title'],
        'value' => $item['code']
      ];
    });
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

  public function getBudgets($filters, $keyword = '', $unit_id) {
    $conditions = [];
    if(isset($filters['periode'])) {
      $conditions = [
        ['periode', '=', $filters['periode']]
      ];
    }
    try {
      $collection = Budgets::withUnitId($unit_id)
        ->options($keyword)
        ->where($conditions)
        ->where('approved', true)
        ->get();

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

  public function getExistingPeriodes($unit_id) {
    try {
      $collection = Budgets::withUnitId($unit_id)
        ->select('periode')
        ->distinct()
        ->get();

      return $collection->transform(function($item) {
        return [
          'value' => $item->periode,
          'label' => $item->periode
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

  public function getUnit($filters, $keyword = null) {
    $user = Auth::user();
    $conditions = $this->buildFilters($filters);

    try {
      if(!isset($keyword)) {
        if(isset($user->prm_perwakilan_id)) {
          $collection = SchoolUnits::where('prm_perwakilan_id', $user->prm_perwakilan_id)->get();
        } else {
          $collection = SchoolUnits::get();
        }
      } else {
        if(isset($user->prm_perwakilan_id)) {
          $collection = SchoolUnits::where('prm_perwakilan_id', $user->prm_perwakilan_id)
          ->where('name', 'like' ,'%'.$keyword.'%')
          ->orWhere('unit_code', 'like', '%'.$keyword.'%')->get();
        } else {
          $collection = SchoolUnits::where('name', 'like' ,'%'.$keyword.'%')
          ->orWhere('unit_code', 'like', '%'.$keyword.'%')->get();
        }
      }

      $options = [
        ["id" => '0', "title" => "SEMUA UNIT"]
      ];
      foreach($collection as $option) {
        array_push($options, [
          "id" => $option->id,
          "title" => $option->name,
          "attributes" => $option,
        ]);
      }
      return $options;
    } catch (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }

  }
}
