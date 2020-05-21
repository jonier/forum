<?php

namespace App\Http\Controllers;

use App\Forum;
use Illuminate\Http\Request;

class ForumsController extends Controller
{
    public function index() {
        $forums = Forum::with(['replies', 'posts'])->paginate(10);
        //dd($forums);
        return view('forums.index', compact('forums'));
    }

    public function show(Forum $forum){
        $posts = $forum->posts()->with(['owner'])->paginate(5);
        return view('forums.detail', compact('forum', 'posts'));
    }
}
