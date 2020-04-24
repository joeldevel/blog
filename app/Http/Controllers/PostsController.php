<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
// use DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch the posts using eloquent
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        // The same can be done without eloquent, just bring in DB library
        // $posts = DB::select("SELECT * FROM posts");
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // validate the form input
        $this->validate($request,[
          'title' => 'required',
          'summary-ckeditor' => 'required'
        ]);
        // return 'Ok';
        // Create the post with the input
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('summary-ckeditor');
        $post->user_id = auth()->user()->id;
        $post->save();
        return redirect('/posts')->with('success','Post created!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post  =Post::find($id);
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // validate the form input
        $this->validate($request,[
          'title' => 'required',
          'summary-ckeditor' => 'required'
        ]);
        // return 'Ok';
        // Create the post with the input
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('summary-ckeditor');
        $post->save();
        return redirect('/posts')->with('success','Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('/posts')->with('success','Posts deleted!');
    }
}
