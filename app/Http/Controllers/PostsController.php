<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // For deleting image
use App\Post;
// use DB;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     * Don't allow unloged users access
     * @return void
     */
    public function __construct()
    {
      // But allow to access index and show views
        $this->middleware('auth',['except'=>['index','show']]);
    }
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
          'summary-ckeditor' => 'required',
          'cover_image' => 'image|nullable|max:1999'
        ]);
        // Handle fole upload
        if($request->hasFile('cover_image'))
        {
          //get the filename with extension
          $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
          ///get just file name
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          //get file extension
          $extension = $request->file('cover_image')->getClientOriginalExtension();
          //filename to store
          $fileNameToStore = $filename.'_'.time().'_'.$extension;
          // uploadimage
          $path = $request->file('cover_image')
                          ->storeAs('public/cover_images',$fileNameToStore);
        }else
        {
          $fileNameToStore = 'noimage.jpg';
        }
        // return 'Ok';
        // Create the post with the input
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('summary-ckeditor');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
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

        //Check for correct user
        if(auth()->user()->id != $post->user_id)
        {
          return redirect('/posts')->with('errors','Unauthoerisxe user');
        }
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
          'summary-ckeditor' => 'required',
          'cover_image' => 'image|nullable|max:1999'
        ]);
        // Handle fole upload
        if($request->hasFile('cover_image'))
        {
          //get the filename with extension
          $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
          ///get just file name
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          //get file extension
          $extension = $request->file('cover_image')->getClientOriginalExtension();
          //filename to store
          $fileNameToStore = $filename.'_'.time().'_'.$extension;
          // uploadimage
          $path = $request->file('cover_image')
                          ->storeAs('public/cover_images',$fileNameToStore);
        }

        // Create the post with the input
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('summary-ckeditor');
        // If the image is not modified , then dont change it
        if($request->hasFile('cover_image'))
        {
          $post->cover_image = $fileNameToStore;
        }
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
        //Check for correct user
        if(auth()->user()->id != $post->user_id)
        {
          return redirect('/posts')->with('errors','Unauthoerisxe user');
        }
        if($post->cover_image != 'noimage.jpg')
        {
          // Delete the image
          Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success','Posts deleted!');
    }
}
