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

  public function getCodeOfAccounts($filters, $withRealization = false, $code=null) {
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

      if(isset($code)) {
        $collection->with(
          ['category' => function($q) use($code) {
            if(is_array($code)) {
              foreach($code as $idx => $item) {
                $q->orWhere('code', 'like', $item.'%');
              }
            } else {
              $q->where('code', 'like', $code.'%');
            }
          }],
          ['category.group' => function($q) use($code) {
            if(is_array($code)) {
              foreach($code as $idx => $item) {
                $q->orWhere('code', 'like', $item.'%');
              }
            } else {
              $q->where('code', 'like', $code.'%');
            }
          }],
          ['category.group.account' => function($q) use($code) {
            if(is_array($code)) {
              foreach($code as $idx => $item) {
                $q->orWhere('code', 'like', $item.'%');
              }
            } else {
              $q->where('code', 'like', $code.'%');
            }
          }]
        );
        // $collection->whereHas(
        //   'category.group.account', function($q) use($code) {
        //     if(is_array($code)) {
        //       foreach($code as $idx => $item) {
        //         $q->orWhere('code', 'like', $item.'%');
        //       }
        //     } else {
        //       $q->where('code', 'like', $code.'%');
        //     }
        //   }
        // )->orWhereHas(
        //   'category.group', function($q) use($code) {
        //     if(is_array($code)) {
        //       foreach($code as $idx => $item) {
        //         $q->orWhere('code', 'like', $item.'%');
        //       }
        //     } else {
        //       $q->where('code', 'like', $code.'%');
        //     }
        //   }
        // )->orWhereHas(
        //   'category', function($q) use($code) {
        //     if(is_array($code)) {
        //       foreach($code as $idx => $item) {
        //         $q->orWhere('code', 'like', $item.'%');
        //       }
        //     } else {
        //       $q->where('code', 'like', $code.'%');
        //     }
        //   }
        // );

        if(is_array($code)) {
          foreach($code as $idx => $item) {
            $collection->orWhere(
              'code', 'like', $item.'%'
            );
          }
        } else {
          $collection->orWhere(
            'code', 'like', $code.'%'
          );
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
