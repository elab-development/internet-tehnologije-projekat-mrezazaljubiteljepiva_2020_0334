<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return new PostCollection($posts);
        
    }

    public function show(Post $post)
    {
        return new PostResource($post);
        /*
            $post = Post::find($id);
            if(is_null($post))
                return response()->json('Data not found.', 404);
            return response()->json($post);
        */
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'photo_path' => 'required|mimes:jpg,jpeg,png',
            'text' => 'required'
        ]);
        $post = new Post();
        $post->photo_path = $request['photo_path'];
        $post->text = $request['text'];
    }

    public function destroy($post_id)
    {
        $post = Post::where('id', $post_id);
        // ubaciti neku autentifikaciju
        /*
            if (Auth::user() != $post->user) {
                return redirect()->back();
            }
        */
        $post->delete();
    }
}
