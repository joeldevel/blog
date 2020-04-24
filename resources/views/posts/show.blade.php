@extends('layouts.app')

@section('content')
  <a href="/posts" class="btn btn-default">Go back</a>
  <h1>{{$post->title}}</h1>
  <div class="">
    <!-- this is needed to display formated text -->
    {!!$post->body!!}
  </div>
  <small>Written on {{$post->created_at}}</small>
  <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
@endsection
