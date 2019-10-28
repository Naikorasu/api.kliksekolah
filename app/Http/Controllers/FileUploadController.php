<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request) {
      $request->validate([
        'file' => 'required|file'
      ]);

      $uploadedFile = $request->file('file');
      $filename = $uploadedFile->getClientOriginalName();
      $extension = $uploadedFile->getClientOriginalExtension();
      $path = Storage::disk('temp')->putFileAs('', $uploadedFile, 'temp_'.Auth::user()->id.'_'.time().'.'.$extension);
      return response()->json([
        'message' => 'File has been successfully uploaded.',
        'data' => [
          'path' => $path        ]
      ]);
    }

    public function download(Request $request, $filename) {
      $path = storage_path() .'/app/public/'. $filename;
      if(file_exists($path)) {
        return response()->download($path, $filename, [
          'Content-Length: ' . filesize($path)
        ]);
      } else {
        exit('Requested file does not exist');
      }
    }
}
