@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/posts/create" class="btn btn-primary">create post</a>
                    <h3>Your blog posts</h3>
                    @if( count($posts)>0 )
                      <table class="table table-striped">
                        <tr>
                          <th>
                            <td>title</td>
                            <td></td>
                            <td></td>
                          </th>
                        </tr>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{$post->title}}</td>
                            <td><a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a> </td>
                            <td>
                              <form class="" action="{{route('/posts/')}}" method="post">

                              </form>
                            </td>
                        </tr>
                        @endforeach
                      </table>
                      @else
                      <p>You have no posts yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
