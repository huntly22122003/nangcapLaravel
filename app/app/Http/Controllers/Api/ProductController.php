<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $products = $query->orderBy('sort_order')->paginate(12);
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    public function getNewProducts()
    {
        $products = Product::where('is_new', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();
        return response()->json($products);
    }

    public function getFeaturedProducts()
    {
        $products = Product::where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();
        return response()->json($products);
    }
}