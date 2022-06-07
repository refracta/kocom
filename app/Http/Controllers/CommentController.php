<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::check()) {
            $comment = new Comment;
            $comment->user_id = Auth::user()->id;
            $comment->post_id = $request->input('post_id');
            $content = $request->input('content');
            $content = strip_tags($content, ['p', 'a', 'i', 'img', 'b', 'span', 'code', 'pre', 'ul', 'li', 'blockquote', 'figure', 'table', 'tbody', 'tr', 'td', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6']);
            $comment->content = $content;
            $reply = $request->input('reply');
            $reply = $reply == 'null' ? null : $reply;
            $comment->reply = $reply;
            $comment->created_at = now();
            $comment->save();
            Auth::user()->point += 15;
            Auth::user()->save();
            return Redirect::back();
        }
    }

    public function delete(Request $request)
    {
        if (Auth::check()) {
            $comment = Comment::find($request->input('comment_id'));
            if (Auth::user()->id == $comment->user_id || Auth::user()->permission >= 10) {
                if (Comment::whereReply($comment->id)->exists()) {
                    $comment->deleted = true;
                    $comment->save();
                } else {
                    $comment->delete();
                }
            }
            return Redirect::back();
        }
    }
}
