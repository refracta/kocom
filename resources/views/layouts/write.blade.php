@extends('layouts.master', ['title' => '글쓰기 - ' . $board->alias . ' 게시판'])

@section('content')
    @include('includes.write', ['board'=>$board, 'modify'=>$modify])
@endsection
