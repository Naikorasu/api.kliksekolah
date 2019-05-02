<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request) {
      $request->validate([
        'file' => 'required|file'
      ]);

      $uploadedFile = $request->file('file');
      $filename = $uploadedFile->getClientOriginalName();
      $extension = $uploadedFile->getClientOriginalExtension();
      $path = $uploadedFile->storeAs('public/temp', 'temp_'.Auth::user()->name.'.'.$extension);
      return response()->json([
        'message' => 'File has been successfully uploaded.',
        'data' => [
          'path' => $path        ]
      ]);
    }
}
