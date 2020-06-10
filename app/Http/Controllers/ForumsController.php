<?php

namespace App\Http\Controllers;

use App\Category;
use App\Forum;
use Illuminate\Http\Request;

class ForumsController extends Controller
{
    public function index() {
        //$forums = Forum::with(['replies', 'posts'])->paginate(2);
        //This line use scopeSearch method that is in Forum.php modele.
        $forums = Forum::search(); 
        //dd($forums);
        return view('forums.index', compact('forums'));
    }

    public function show(Forum $forum){
        $posts = $forum->posts()->with(['owner'])->paginate(5);
        $categories = Category::pluck('name', 'id');

        return view('forums.detail', compact('forum', 'posts', 'categories'));
    }

    public function store() {
        $this->validate(request(), [
            'name' => 'required|max:100|unique:forums',
            'description' => 'required|max:200'
        ]);
        Forum::create(request()->all());
        return back()->with('message', ['success', __("Forum created successfully")]);
    }

    public function search() {
        if(request()->method('POST')) {
            $search = request('search');
            
            if($search) {
                request()->session()->put('search', $search);
                request()->session()->save();
            }else{
                request()->session()->forget('search');
            }
        }
        
        return redirect('/');
    }

    public function clearSearch() {
        request()->session()->forget('search');
        return back();
    }
}
