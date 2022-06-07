<?php

namespace App\Http\Controllers;

use App\Models\Recommend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RecommendController extends Controller
{
    public function toggle(Request $request)
    {
        if (Auth::check()) {
            $post_id = $request->input('post_id');
            $previous = Recommend::wherePostId($request->input('post_id'))->first();
            if ($previous == null) {
                $recommend = new Recommend;
                $recommend->post_id = $post_id;
                $recommend->user_id = Auth::user()->id;
                $recommend->save();
            } else {
                $previous->delete();
            }
            return Redirect::back();
        }
    }
}
