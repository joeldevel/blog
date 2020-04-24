@extends('layouts.app')

@section('content')
  <h1>Creat a post</h1>

<form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
   <div class="form-group">
     @csrf
     <label for="title">Title</label>
     <input type="text" class="form-control" name="title" placeholder="Title"/>
   </div>
   <div class="form-group">
     <label for="summary-ckeditor">Body</label>
     <textarea class="form-control" name="summary-ckeditor"  cols="30" rows="10"
      placeholder="Body Text"></textarea>
   </div>
   <div class="form-group">
     <input type="file" name="cover_image" value="">
   </div>
   <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection
