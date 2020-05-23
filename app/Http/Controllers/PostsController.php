<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function show(Post $post) {
        $replies = $post->replies()->with('author')->paginate(2);
        return view('post.detail', compact('post', 'replies'));
    }

    public function store(PostRequest $post_request) {
        Post::create($post_request->input());
        return back()->with('message', ['success', __("Post created sussesfull")]);
    }
}
