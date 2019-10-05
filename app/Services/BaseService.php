<?php

namespace App\Services;

use Auth;
use App\Classes\FunctionHelper;
use App\User;
use App\Exceptions\SchoolUnitException;
use App\SchoolUnits;
use App\EntityUnits;
use App\Workflows;

class BaseService{

  protected $filterable = [];
  protected $fh;

  public function __construct(FunctionHelper $fh) {
    $this->fh = $fh;
  }

  protected function getCurrentUser() {
    $user = User::with('userGroup')->find(Auth::user()->id);
    return $user;
  }

  protected function buildFilters($filters) {
    $conditions = [];
    if(isset($filters)) {
      if(isset($this->filterable)) {
        foreach($filters as $key => $value) {
          if(in_array($key, $this->filterable)) {
            array_push($conditions, [$key, '=', $value]);
          }
        }
      } else {
        foreach($filters as $key => $value) {
          array_push($conditions, [$key, '=', $value]);
        }
      }
    }

    return $conditions;
  }

  protected function generateUniqueId($accountType, $code_of_account = null) {
    $user = Auth::user();
    $user_email = $user->email;
    if(isset($code_of_account)) {
      return $this->fh::generate_unique_key($user_email . ";" . "DETAIL" . ";" . $accountType . ";" . $code_of_account . ";");
    } else {
      return $this->fh::generate_unique_key($user_email . ";" . "DETAIL" . ";" . $accountType . ";");
    }
  }

  protected function getPagination($result) {
    return [
      'count' => $result->count(),
      'current_page' => $result->currentPage(),
      'first_item' => $result->firstItem(),
      'options' => $result->getOptions(),
      'next_page_url' => $result->nextPageUrl(),
      'per_page' => $result->perPage(),
      'previous_page_url' => $result->previousPageUrl(),
      'total' => $result->total()
    ];
  }

  protected function validateSchoolUnit($school_unit_id) {
    if(isset($school_unit_id)) {
      if(Auth::user()->prm_school_units_id !== $school_unit_id) {
        throw new SchoolUnitException();
      }
    }
  }

  protected function updateEntityUnit($model) {
    $schoolUnitId = Auth::user()->prm_school_units_id;

    $entityUnit = new EntityUnits([
      'prm_school_units_id' => $schoolUnitId
    ]);

    $model->school_unit()->save($entityUnit);
  }

  protected function updateWorkflow($model, $is_done = false, $is_rejected = false) {
    $userGroup = Auth::user()->userGroup()->first();

    if($is_rejected == false) {
      switch($userGroup->name) {
          case 'Keuangan Sekolah':
            $nextRole = 'Kepala Sekolah';
            break;
          case 'Kepala Sekolah':
            $nextRole = 'Korektor Perwakilan';
            break;
          case 'Korektor Perwakilan':
            $nextRole = 'Manager Keuangan';
            break;
          case 'Manager Keuangan':
            $nextRole = 'Bendahara';
            break;
          default:
            $nextRole = 'Bendahara';
      }
      $prevRole = $userGroup->name;
    } else {
      switch($userGroup->name) {
          case 'Kepala Sekolah':
            $prevRole = 'Keuangan Sekolah';
            break;
          case 'Korektor Perwakilan':
            $prevRole = 'Kepala Sekolah';
            break;
          case 'Manager Keuangan':
            $prevRole = 'Korektor Perwakilan';
            break;
          case 'Bendahara':
            $prevRole = 'Korektor Perwakilan';
            break;
          default:
            $prevRole = 'Bendahara';
      }
      $nextRole = $userGroup->name;
    }

    $workflow = [
      'prev_role' => $prevRole,
      'next_role' => $nextRole,
      'is_done' => $is_done
    ];


    $model->workflow()->updateOrCreate(
      [
        'entity_type' => get_class($model),
        'entity_id' => $model->id
      ],
      $workflow
    );
  }

  protected function validateUserGroupForSaving($model) {
    $user = Auth::user()->load('userGroup');

    $model->load('workflow');
    if($user->userGroup->name == $model->workflow['nextRole']) {
      return true;
    } else {
      return false;
    }
  }

  protected function validateUserGroupForSubmit($model) {
    $user = Auth::user()->load('userGroup');

    $model->load('workflow');

    if($user->userGroup->name == $model->workflow['nextRole']) {
      return true;
    } else {
      return false;
    }
  }
}
