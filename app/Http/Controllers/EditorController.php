<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            //get filename with extension
            $fileNameWithExt = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $fileName2Store = $filename . '_' . time() . '.' . $extension;

            //Upload File
            $request->file('upload')->storeAs('public/uploads', $fileName2Store);

            echo json_encode([
                'default' => asset('storage/uploads/' . $fileName2Store),
            ]);
        }
    }
}
