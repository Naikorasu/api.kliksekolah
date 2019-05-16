<?php

namespace App\Exceptions;

use Exception;

class ApprovalException extends Exception
{

  public $status =400, $type, $id;

  public function __construct($message, $type, $id) {
    parent::__construct('Failed to '.$type.'. Data might have been approved or rejected.');
    $this->id = $id;
  }

  public function render($request)
  {
    if($request->expectsJson()) {
      return $this->handleJson();
    }

    return redirect()->back()
      ->withInput()
      ->withErrors($this->getMessage());
  }

  private function handleJson() {
    return response()->json([
      'error' => true,
      'message' => $this->getMessage(),
      'data' => [
        'id' => $this->id
      ]
    ], $this->status);
  }

  public function withStatus($status)
  {
    $this->status = $status;
    return $this;
  }
}
