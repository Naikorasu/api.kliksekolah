<?php

namespace App\Services;

class WorkflowService extends BaseService {

  public function run($lastUser, $isApproved = false, $isSubmitted = false) {
    $currentUser = $this->getCurrentUser();
    $currentUserGroup = $currentUser->user_group;
    $lastUserGroup = $lastUser->user_group;

    $workflow = [
      'result' => [
        'submitted' => $isSubmitted,
        'approved' => $isApproved,
        'user_id' => $currentUser->id
      ],
      'createRevision' => false
    ];

    if($isApproved) {
      return false;
    }

    switch($type) {
      case 'SAVE':
        if($isApproved == false) {
          if($isSubmitted) {
            if($currentUserGroup->priority < $lastUserGroup->priority) {
              $workflow->createRevision = true;
              $workflow->result->submitted = false;
            } else if($lastUserGroup->priority == 1 && $currentUserGroup->priority == 5) {
              $workflow->createRevision = true;
            } else {
              $workflow->$result->user_id = $lastUser->id;
            }
          } else {
            if($currentUserGroup->priority == $lastUserGroup->priority) {
              $result->submitted = false;
            } else {
              $result->user_id = $lastUser->id;
            }
          }
        }
        break;
      case 'SUBMIT':
        if($currentUserGroup->priority > 1) {
          $result->submitted = true;
        }
        break;
      case 'APPROVE':
        if($currentUserGroup->priority == 1) {
          $result->submitted = true;
          $result->approved = true;
        }
        break;
      case 'REJECT':
        if($currentUserGroup->priority == 1) {
          $result->submitted = false;
          $result->approved = false;
        }
        break;
      default:
        break;
    }

    return $result;
  }
}
