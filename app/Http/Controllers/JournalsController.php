<?php

namespace App\Http\Controllers;

use App\Services\JournalsService;
use App\Services\JournalRealizationService;
use Illuminate\Http\Request;

class JournalsController extends Controller
{
    private $journalsService;
    private $journalRealizationService;

    public function __construct(JournalsService $journalsService, JournalRealizationService $journalRealizationService) {
      $this->journalsService = $journalsService;
      $this->journalRealizationService = $journalRealizationService;
    }

    public function get(Request $request, $type='KAS') {
      $journal = $this->journalsService->get($request->id,strtoupper($type));

      return response()->json([
        'data' => $journal
      ]);
    }

    public function save(Request $request, $type='KAS') {
      $journal = $this->journalsService->save($request, strtoupper($type));

      return response()->json([
        'message' => 'Successfully saved journal',
        'data' => $journal
      ]);
    }

    public function list(Request $request, $type='KAS') {
      if($type == 'realization') {
        $journals = $this->journalRealizationService->list();
      } else {
        $journals = $this->journalsService->list($type);
      }
      return response()->json([
        'data' => $journals
      ]);
    }

    public function delete(Request $request, $type) {
      $journals = $this->journalsService->delete($request->id);
      return response()->json([
          'data' => $journals
      ]);
    }
}
