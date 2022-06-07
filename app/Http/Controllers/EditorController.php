<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileNameWithExt = $request->file('upload')->getClientOriginalName();

            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('upload')->getClientOriginalExtension();

            $fileName2Store = $filename . '_' . substr(sha1(time() . rand()), 0, 5) . '.' . $extension;

            $request->file('upload')->storeAs('public/uploads', $fileName2Store);

            echo json_encode([
                'default' => '/storage/uploads/' . $fileName2Store,
            ]);
        }
    }
}
