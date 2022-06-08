<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RecommendController;
use App\Http\Controllers\TaskController;
use App\Models\Board;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('test', function ($data) {
    return view('layouts.test', $data);
})->name('test');

Route::post('comments/create', [CommentController::class, 'store'])->name('comments.create');
Route::post('comments/delete', [CommentController::class, 'delete'])->name('comments.delete');
Route::post('recommends', [RecommendController::class, 'toggle'])->name('recommends');
Route::post('posts/create', [PostController::class, 'store'])->name('posts.create');
Route::post('posts/delete', [PostController::class, 'delete'])->name('posts.delete');
Route::post('upload/image', [EditorController::class, 'uploadImage'])->name('upload.image');


Route::get('/', function () {
    return view('layouts.root');
})->name('root');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';


Route::get('login', function () {
    return view('layouts.login');
})->name('login');

Route::get('register', function () {
    return view('layouts.register');
})->name('register');

Route::get('map-standalone', function () {
    return view('layouts.map-standalone');
})->name('map-standalone');

Route::get('map', function () {
    return view('layouts.map');
})->name('map');

Route::get('write/{modify}', function ($modify) {
    $modify = Post::find($modify);
    if($modify != null && Auth::user()->id == $modify->user_id){
        $board = $modify->getBoard();
        return view('layouts.write', ['board'=>$board, 'modify'=>$modify]);
    }
})->middleware(['auth'])->name('modify');

Route::get('{board}', function (Request $request, $board) {
    $search = $request->input('search');
    $option = $request->input('option');
    return view('layouts.board', ['board' => Board::getBoardByName($board), 'search' => $search, 'option' => $option]);
})->middleware(['auth'])->name('board');

Route::get('{board}/write', function ($board) {
    $board = Board::getBoardByName($board);
    if(!$board->isAllBoard()){
        return view('layouts.write', ['board'=>$board, 'modify'=>null]);
    }
})->middleware(['auth'])->name('write');

Route::get('p/{number}', function ($number) {
    $post = Post::find($number);
    return view('layouts.post', ['post' => $post]);
})->middleware(['auth'])->name('post.number');

Route::get('{board}/{number}', function ($board, $number) {
    $board = Board::getBoardByName($board);
    $post = $board->getPost($number);
    return view('layouts.post', ['post' => $post]);
})->middleware(['auth'])->name('post');
