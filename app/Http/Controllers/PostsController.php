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

		if($post_request->hasFile('file') && $post_request->file('file')->isValid()) {
			$filename = uploadFile('file', 'posts');
			$post_request->merge(['attachment' => $filename]);
		}
        
        //dd($post_request->input());

        Post::create($post_request->input());
        return back()->with('message', ['success', __("Post created sussesfully")]);
    }

    public function destroy(Post $post) {
        $post->delete();
        return back()->with('message', ['success', __("Post and replies delete sussesfully")]);
    }
}
