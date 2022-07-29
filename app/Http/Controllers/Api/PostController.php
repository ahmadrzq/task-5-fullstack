<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(15);
        return response()->json([
            "success" => true,
            "message" => "Post List",
            "data" => $posts
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
            'category_id' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        $posts = Post::create($input);
        return response()->json([
            "success" => true,
            "message" => "Post created successfully.",
            "data" => $posts
        ]);
    }

    public function show($id)
    {
        $posts = Post::find($id);
        if (is_null($posts)) {
            return response(['error' => 'Post Not Found']);
        }
        return response()->json([
            "success" => true,
            "message" => "Post retrieved successfully.",
            "data" => $posts
        ]);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
            'category_id' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        $post = Post::whereId($id)->update([
            'title'     => $request->input('title'),
            'content'   => $request->input('content'),
            'image'   => $request->input('image'),
            'category_id'   => $request->input('category_id'),
            'user_id'   => $request->input('user_id'),
        ]);

        return response()->json([
            "success" => true,
            "message" => "Post updated successfully.",
            "data" => $post
        ]);
    }

    public function destroy($id)
    {
        $posts = Post::find($id);
        $posts->delete();
        return response()->json([
            "success" => true,
            "message" => "Post deleted successfully.",
            "data" => $posts
        ]);
    }
}
