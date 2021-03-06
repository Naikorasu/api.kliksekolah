<?php

namespace App\Services;

use Auth;
use DateTime;
use App\NonBudgets;
use App\SchoolUnits;
use App\Exceptions\DataNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NonBudgetsService extends BaseService {

  public function list($filters, $unit_id = null) {
    $conditions = $this->buildFilters($filters);

    if(!isset($unit_id)) {
      $user = Auth::user();

      $unit_id = $user->prm_school_units_id;

      if(!isset($unit_id) && isset($user->prm_perwakilan_id)) {
        $unit_id = SchoolUnits::select('id')->where('prm_perwakilan_id', $user->prm_perwakilan_id)->get();
      }
    };

    return NonBudgets::where($conditions)->withUnitId($unit_id)->orderBy('created_at','DESC')->paginate(5);
  }

  public function get($id,$submitted=false,$approved=false) {
    try {
      $nonBudget = NonBudgets::where([
        ['submitted', '=', $submitted],
        ['is_approved', '=', $approved]
        ])->findOrFail($id);
      return $nonBudget;
    } catch  (ModelNotFoundException $exception) {
      throw new DataNotFoundException($exception->getMessage());
    }
  }

  public function save($data, $unit_id = null) {
    $data['date'] = ($data['date']) ? date('Y-m-d', (DateTime::createFromFormat('Y-m-d',$data['date']))->getTimestamp()) : date('Y-m-d');
    $data['user_id'] = Auth::user()->id;

    if(isset($data['id'])){
      $nonBudget = $this->get($data['id']);
      $nonBudget->update($data);
    } else {
      $nonBudget = new NonBudgets($data);
      $nonBudget->save();
    }

    $this->updateEntityUnit($nonBudget, $unit_id);

    return $nonBudget;
  }

  public function cancel($id) {
    $nonBudget = $this->get($id,true,false);
    return $nonBudget->update(['submitted' => false]);
  }

  public function delete($id) {
    $nonBudget = $this->get($id,false,false);
    $nonBudget->forceDelete();
    return $nonBudget;
  }

  public function submit($id) {
    $nonBudget = $this->get($id);
    return $nonBudget->update(['submitted' => true]);
  }

  public function updateStatus($id, $type) {
    $nonBudget = $this->get($id,true,false);

    if($type == 'approve') {
      return $nonBudget->update(['is_approved' => true]);
    } else {
      return $nonBudget->update(['is_approved' => true, 'submitted' => false]);
    }
  }
}
