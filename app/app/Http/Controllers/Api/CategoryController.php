<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return response()->json($categories);
    }

    public function show($id)
    {
        $category = Category::with('children', 'products')->findOrFail($id);
        return response()->json($category);
    }

    public function getProducts($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return response()->json($category->products);
    }
}