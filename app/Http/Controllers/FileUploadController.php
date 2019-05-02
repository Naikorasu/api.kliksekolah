<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
=======
use Auth;
>>>>>>> permintaan-dana
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request) {
      $request->validate([
        'file' => 'required|file'
      ]);
<<<<<<< HEAD
      $uploadedFile = $request->file;
      $filename = $uploadedFile->getClientOriginalName();
      $extension = $uploadedFile->getClientOriginalExtensions();
      $path = $uploadedFile->storeAs('temp', 'temp_'.time().'_'.$filename.'.'.$extension);
      return response()->json([
        'message' => 'File has been successfully uploaded.',
        'data' => [
          'path' => $uploadedFile
        ]
=======

      $uploadedFile = $request->file('file');
      $filename = $uploadedFile->getClientOriginalName();
      $extension = $uploadedFile->getClientOriginalExtension();
      $path = $uploadedFile->storeAs('public/temp', 'temp_'.Auth::user()->name.'.'.$extension);
      return response()->json([
        'message' => 'File has been successfully uploaded.',
        'data' => [
          'path' => $path        ]
>>>>>>> permintaan-dana
      ]);
    }
}
