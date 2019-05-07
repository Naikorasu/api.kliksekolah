<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OptionsService;

class OptionsController extends Controller
{

    private $optionsService;

    public function returnOption($request, $data) {
      return response()->json([
        'message' => 'Successfully loaded options',
        'data' => $data
      ]);
    }

    public function __construct(OptionsService $optionsService) {
      $this->optionsService = $optionsService;
    }

    public function code_of_account(Request $request) {
      $data = $this->optionsService->getCodeOfAccounts($request->filters);
      return $this->returnOption($request, $data);
    }

    public function periode(Request $request) {
      $data = $this->optionsService->getPeriodes($request->filters);
      return $this->returnOption($request, $data);
    }

    public function code_of_account_realization(Request $request) {
      $data = $this->optionsService->getCodeOfAccounts($request->filters, true);
      return $this->returnOption($request, $data);
    }

    public function periode_realization(Request $request) {
      $data = $this->optionsService->getPeriodes($request->filters, true);
      return $this->returnOption($request, $data);
    }
}
