<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;

class PostController extends Controller
{
    public function delete(Request $request)
    {
        if (Auth::check()) {
            $post_id = $request->input('post_id');
            $post = Post::find($post_id);
            if ($post->user_id == Auth::user()->id || Auth::user()->permission >= 10) {
                $post->delete();
                return Redirect::route('board', $post->getBoard()->name);
            }
        }
    }

    public function store(Request $request)
    {
        if (Auth::check()) {


            $board_name = $request->input('board_name');
            $board = Board::getBoardByName($board_name);

            if($board->name =='notice' && Auth::user()->permission < 10){
                return Redirect::route('board', $board->name)->withErrors('공지 게시판은 관리자만 작성할 수 있습니다.');
            }

            $title = $request->input('title');
            $content = $request->input('content');
            $content = strip_tags($content, ['p', 'a', 'i', 'img', 'b', 'span', 'code', 'pre', 'ul', 'li', 'blockquote', 'figure', 'table', 'tbody', 'tr', 'td', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6']);
            if ($request->input('modify') == null) {
                $post = new Post;
                $is_modify = false;
                $post->title = $title;
                $post->content = $content;
                $post->created_at = Carbon::now();
                $post->updated_at = Carbon::now();
                $post->board_id = $board->id;
                $post->user_id = Auth::user()->id;
            } else {
                $post = Post::find($request->input('modify'));
                $is_modify = true;
                $post->title = $title;
                $post->content = $content;
                if ($post->getUser()->id != Auth::user()->id) {
                    return Redirect::route('board', $board->name)->withErrors('본인의 글만 수정할 수 있습니다.');
                }
                $post->updated_at = Carbon::now();
            }
            $baseFiles = $post->files ? json_decode($post->files) : [];

            $uploaded = $request->input('uploaded');
            $uploadedCount = $uploaded ? count($uploaded) : 0;
            $fileNames = [];
            $files = $request->file('files');

            $fn1 = $files == null ? 0 : min(count($files), 5);
            for ($i = 0; $i < $fn1; $i++) {
                $baseFiles[$i + $uploadedCount] = $files[$i];
            }

            $files = $baseFiles;
            $fn = $fn1 + $uploadedCount;
            for ($i = 0; $i < $fn; $i++) {
                if ($i < $uploadedCount) {
                    $fileNames[$i] = $files[$i];
                    continue;
                }
                $file = $files[$i];
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $fullName = $fileName . '_' . substr(sha1(time() . rand()), 0, 5) . '.' . $ext;
                $file->storeAs('public/uploads', $fullName);
                $fileNames[$i] = $fullName;
            }
            $post->files = json_encode($fileNames);

            if (!$is_modify) {
                if ($board->name == 'qna' || $board->name == 'quot') {
                    if (Auth::user()->point - 30 <= 0) {
                        return Redirect::route('board', $board->name)->withErrors('포인트가 부족합니다!\nQnA 또는 견적 게시판은 게시글 1개당 포인트 30점이 소모됩니다.');
                    } else {
                        Auth::user()->point -= 30;
                        Auth::user()->save();
                    }
                    $post->save();
                } else {
                    $post->save();
                    Auth::user()->point += 50;
                    Auth::user()->save();
                }
            } else {
                $post->save();
            }
            return Redirect::route('post', ['board' => $board->name, 'number' => $post->getBoardNumber()]);
        }
    }
}
