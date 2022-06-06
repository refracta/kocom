@extends('layouts.master', ['title' => $post->title])

@php
    $post->increaseView();
@endphp

@section('content')
    @include('includes.post', ['post' => $post])
@endsection
