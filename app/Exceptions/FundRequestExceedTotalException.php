<?php

namespace App\Exceptions;

use Exception;

class FundRequestsExceedTotalException extends Exception
{
  private $status = 400;
  private $total, $amount;

  public function __construct($total, $amount) {
    $this->total = $total;
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
      'message' => 'Requested amount ('.$this->amount.') exceeds total ('.$this->total.')'
    ], $this->status);
  }

  public function withStatus($status)
  {
    $this->status = $status;
    return $this;
  }
}
