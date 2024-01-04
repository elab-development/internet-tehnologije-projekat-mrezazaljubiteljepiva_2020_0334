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


}
