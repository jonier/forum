<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function show(Post $post) {
        $replies = $post->replies()->with('author')->paginate(2);
        return view('post.detail', compact('post', 'replies'));
    }
}
