<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;

class CommentController extends Controller
{
    public function index()
    {
        $comment = Comment::all();
        return new CommentCollection($comment);
    }
}
