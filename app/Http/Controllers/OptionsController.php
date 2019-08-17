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

    public function code_of_account(Request $request, $type=null) {
      $data = $this->optionsService->getCodeOfAccounts($request->filters, isset($type), $request->codes, $request->categories, $request->groups, $request->classes);
      return $this->returnOption($request, $data);
    }

    public function periode(Request $request, $type=null) {
      $data = $this->optionsService->getPeriodes($request->filters, isset($type));
      return $this->returnOption($request, $data);
    }

    public function fund_request(Request $request) {
      $data = $this->optionsService->getFundRequests($request->filters);
      return $this->returnOption($request, $data);
    }

    public function budget(Request $request, $type=null) {
      $data = $this->optionsService->getBudgets($request->filters, $request->keyword);
      return $this->returnOption($request, $data);
    }

    public function pph(Request $request) {
      $data = $this->optionsService->getPph($request->filters);
      return $this->returnOption($request, $data);
    }

    public function unit(Request $request) {
      $data = $this->optionsService->getUnit($request->filters);
      return $this->returnOption($request, $data);
    }
}
