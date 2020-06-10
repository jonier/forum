<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RepliesResource;
use App\Reply;

class RepliesController extends Controller
{
    public function index(Reply $reply) {
        return RepliesResource::collection($reply->paginate(2));
    }
}
