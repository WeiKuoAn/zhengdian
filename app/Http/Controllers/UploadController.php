<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if (!$file->isValid()) {
                return response()->json(['error' => '檔案上傳失敗'], 400);
            }

            $path = $file->store('files', 'public');

            return response()->json(['location' => asset('storage/' . $path)]);
        }

        return response()->json(['error' => '未收到檔案'], 400);
    }
}
