<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReportService;

class ReportController extends Controller
{
    private $reportService;

    public function __construct(ReportService $reportService) {
      $this->reportService = $reportService;
    }

    public function get(Request $request, $type) {
      $data = $this->reportService->get($type, $request->from, $request->to);

      return response()->json(
        $data
      );
    }

    public function balance(Request $request) {
      $data = $this->reportService->balance();

      return response()->json([
        'data' => $data
      ]);
    }
}
