<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category')->where('is_active', true);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(10);
        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Post::with('category')->findOrFail($id);
        return response()->json($post);
    }

    public function getRecent()
    {
        $posts = Post::where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
        return response()->json($posts);
    }
}