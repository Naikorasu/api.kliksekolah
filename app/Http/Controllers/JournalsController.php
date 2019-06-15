<?php

namespace App\Http\Controllers;

use App\Services\JournalsService;
use Illuminate\Http\Request;

class JournalsController extends Controller
{
    private $journalsService;

    public function __construct(JournalsService $journalsService) {
      $this->journalsService = $journalsService;
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
      $journals = $this->journalsService->list($type);

      return response()->json([
        'message' => 'successfully saved journal',
        'data' => $journals
      ]);
    }

    public function delete(Request $request, $type) {

    }
}
