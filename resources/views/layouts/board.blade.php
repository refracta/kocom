@extends('layouts.master', ['title' => $board->alias . ' 게시판'])

@section('content')
    @include('includes.board', ['board'=>$board, 'search'=>$search, 'option'=>$option])
@endsection
