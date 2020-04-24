@extends('layouts.app')

@section('content')
  <h1>Edit a post</h1>

<form method="post" action="{{ route('posts.update', ['id' => $post->id]) }}"
  enctype="multipart/form-data">
   <div class="form-group">
     @csrf
     <label for="title">Title</label>
     <input type="text" class="form-control" name="title" placeholder="Title"
     value="{{$post->title}}"/>
   </div>
   <div class="form-group">
     <label for="summary-ckeditor">Body</label>
     <textarea class="form-control" name="summary-ckeditor"  cols="30" rows="10"
      placeholder="Body Text">{{$post->body}}</textarea>
   </div>
   <div class="form-group">
     <input type="file" name="cover_image" value="">
   </div>
   <button type="submit" class="btn btn-primary">Submit</button>
   <input type="hidden" name="_method" value="PUT">
</form>

@endsection
