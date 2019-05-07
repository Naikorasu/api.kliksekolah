<?php

namespace App\Exceptions;

use Exception;

class DataSaveFailureException extends Exception
{
  public function render($request, Exception $exception)
  {
      return parent::render($request, $exception);
  }
}
