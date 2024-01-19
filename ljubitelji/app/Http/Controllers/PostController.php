<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return new PostCollection($posts);
        
    }
    
    public function store(Request $request)
    {
        /*
            $this->validate($request, [
                'photo_path' => 'required|mimes:jpg,jpeg,png',
                'text' => 'required'
            ]);
            $post = new Post();
            $post->photo_path = $request['photo_path'];
            $post->text = $request['text'];
        */
        $request->validate([
            'text' => 'required',
            'photo_path' => 'required',
            'user_id' => 'required'
        ]);

        /*
        $requestData = $request->all();
        $fileName = time().$request->file('photo')->getClientOriginalName();
        $path = $request->file('photo')->storeAs('images', $fileName, 'public');
        $requestData["photo"] = '/storage/'.$path;
        */

        if($validator->fails())
            return response()->json($validator->errors());
        $post = Post::create([
            'text' => $request->text,
            'photo_path' => $request->photo_path,
            'user_id' => Auth::user()->id,
        ]);
        return response()->json(['Post uspesno kreiran.', new PostResource($post)]);
    }

    public function editPostText(Request $request, Post $post)
    {
        /*
            if (Auth::user() != $post->user) {
                return redirect()->back();
            }
        */
        $validator = Validator::make($request->all(), [
            'text' => 'required'
        ]);

        if($validator->fails())
            return response()->json($validator->errors());
        
        $post->text = $request->text;
        $post->save();
        return response()->json(['Post uspesno izmenjen.', new PostResource($post)]);
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
        return response()-json('Post obrisan.');
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
