<?php

namespace App\Exceptions;

use Exception;

class DataNotFoundException extends Exception
{

  public $data = [];

  public $status = 400;

  public function __construct($message) {
    parent::__construct($message);
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
      'data' => $this->data
    ], $this->status);
  }

  public function withData(array $data)
  {
    $this->data = $data;
    return $this;
  }
  
  public function withStatus($status)
  {
    $this->status = $status;
    return $this;
  }
}
