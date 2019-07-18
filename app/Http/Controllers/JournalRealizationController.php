<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JournalRealizationService;

class JournalRealizationController extends Controller
{
    private $journalRealizationService;

    public function __construct(JournalRealizationService $journalRealizationService) {
      $this->journalRealizationService = $journalRealizationService;
    }

    public function list(Request $request) {
      $data = $this->journalRealizationService->list();

      return response()->json([
        'data' => $data
      ]);
    }
}
