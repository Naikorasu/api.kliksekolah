<?php

namespace App\Exceptions;

use Exception;

class FundRequestExceedRemainsException extends Exception
{

  private $status = 400;
  private $remains, $amount;

  public function __construct($remains, $amount) {
    $this->remains = $remains;
    $this->amount = $amount;
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
      'message' => 'Requested amount ('.$this->amount.') exceeds remaining amount ('.$this->remains.')'
    ], $this->status);
  }

  public function withStatus($status)
  {
    $this->status = $status;
    return $this;
  }
}
