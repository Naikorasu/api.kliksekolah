<?php

namespace App\Exceptions;

use Exception;

class SchoolUnitException extends Exception
{
  public $status = 400;

  public function __construct() {
    parent::__construct('School Unit not found');
  }

  public function render($request)
  {
    return response()->json([
      'error' => true,
      'message' => $this->getMessage()
    ], $this->status);
  }
}
