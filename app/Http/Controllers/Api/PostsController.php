<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostsResource;
use App\Post;

class PostsController extends Controller
{
    public function index(Post $post) {
        return PostsResource::collection($post->with('replies')->paginate(2));
    }

    public function show(Post $post) {
        return new PostsResource($post);
    }
}
