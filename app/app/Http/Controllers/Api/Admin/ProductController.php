<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\ProductDTO;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'search', 'is_new', 'is_featured']);
        $products = $this->productService->getProducts($filters, $request->get('per_page', 20));
        return response()->json($products);
    }

    public function show($id)
    {
        $product = $this->productService->getProduct($id);
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'extraname' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:50',
            'price' => 'nullable|numeric',
            'brand' => 'nullable|string|max:100',
            'origin' => 'nullable|string|max:100',
            'model_no' => 'nullable|string|max:100',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'technic_info' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|max:2048',
            'is_new' => 'boolean',
            'is_featured' => 'boolean',
            'has_gallery' => 'boolean',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $dto = new ProductDTO($validated);
        // Gán file nếu có
        if ($request->hasFile('thumbnail_file')) {
            $dto->thumbnail_file = $request->file('thumbnail_file');
        }

        $product = $this->productService->createProduct($dto);
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'extraname' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:50',
            'price' => 'nullable|numeric',
            'brand' => 'nullable|string|max:100',
            'origin' => 'nullable|string|max:100',
            'model_no' => 'nullable|string|max:100',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'technic_info' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|max:2048',
            'is_new' => 'boolean',
            'is_featured' => 'boolean',
            'has_gallery' => 'boolean',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $dto = new ProductDTO($validated);
        if ($request->hasFile('thumbnail_file')) {
            $dto->thumbnail_file = $request->file('thumbnail_file');
        }

        $product = $this->productService->updateProduct($id, $dto);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return response()->json(['message' => 'Xóa thành công']);
    }

    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'orders' => 'required|array',
        ]);
        $this->productService->updateProductOrder($validated['ids'], $validated['orders']);
        return response()->json(['message' => 'Cập nhật thứ tự thành công']);
    }
}