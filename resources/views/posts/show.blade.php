@extends('layouts.app')

@section('content')
  <a href="/posts" class="btn btn-default">Go back</a>
  <h1>{{$post->title}}</h1>
  <img src="/storage/cover_images/{{$post->cover_image}}" alt="" style="width:100%" class="mb-4">
  <div class="">
    <!-- this is needed to display formated text -->
    {!!$post->body!!}
  </div>
  <small>Written at {{ $post->created_at}} by {{ $post->user['name']}}</small>

  @if(!Auth::guest())
  {{-- only the post creator can edit the post --}}
   @if(Auth::user()->id == $post->user_id)
    <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
    <form class="pull-right" action="{{ route('posts.destroy',['id'=>$post->id]) }}"
       method="post">
      @csrf
      <input type="submit" name="" value="Delete" class="btn btn-danger">
      <input type="hidden" name="_method" value="DELETE">
    </form>
    @endif
  @endif
@endsection
