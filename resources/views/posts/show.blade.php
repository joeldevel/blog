@extends('layouts.app')

@section('content')
  <a href="/posts" class="btn btn-default">Go back</a>
  <h1>{{$post->title}}</h1>
  <div class="">
    <!-- this is needed to display formated text -->
    {!!$post->body!!}
  </div>
  <small>Written at {{ $post->created_at}} by {{ $post->user['name']}}</small>
  <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
  <form class="pull-right" action="{{ route('posts.destroy',['id'=>$post->id]) }}" method="post">
    @csrf
    <input type="submit" name="" value="Delete" class="btn btn-danger">
    <input type="hidden" name="_method" value="DELETE">
  </form>
@endsection
