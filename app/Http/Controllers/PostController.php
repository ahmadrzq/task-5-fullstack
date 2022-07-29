<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {   
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
        }

        return view('home', [
            "title" => "All News",
            "active" => "All News",
            "posts" => Post::latest()->filter(request(['category']))->paginate(7)->withQueryString(),
            "categories" => Category::all(),
        ]);
    }

    public function show(Post $post){
        return view('post', [
            "title" => "Single Post",
            "active" => "All News",
            // "title" => Post::find($slug)->firstWhere('title', $slug),
            "post" => $post,
            "categories" => Category::all(),
        ]);
    }
}
