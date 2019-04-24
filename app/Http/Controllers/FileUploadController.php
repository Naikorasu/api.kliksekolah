<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request) {
      $request->validate([
        'file' => 'required|file'
      ]);
      $uploadedFile = $request->file;
      $filename = $uploadedFile->getClientOriginalName();
      $extension = $uploadedFile->getClientOriginalExtensions();
      $path = $uploadedFile->storeAs('temp', 'temp_'.time().'_'.$filename.'.'.$extension);
      return response()->json([
        'message' => 'File has been successfully uploaded.',
        'data' => [
          'path' => $uploadedFile
        ]
      ]);
    }
}
