<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\ProductPostDTO;
use App\Services\Interfaces\ProductPostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductPostController extends Controller
{
    protected $productPostService;

    public function __construct(ProductPostServiceInterface $productPostService)
    {
        $this->productPostService = $productPostService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'is_active']);
        $perPage = $request->input('per_page', 20);

        $posts = $this->productPostService->getProductPosts($filters, $perPage);
        return response()->json($posts);
    }

    public function show($id)
    {
        try {
            $post = $this->productPostService->getProductPost($id);
            return response()->json($post);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Không tìm thấy bài đăng'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'content' => 'nullable|string',
                'posted_at' => 'nullable|date',
                'is_active' => 'boolean',
                'sort_order' => 'nullable|integer',
            ]);

            $dto = new ProductPostDTO($validated);
            $post = $this->productPostService->createProductPost($dto);

            return response()->json($post, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'content' => 'nullable|string',
                'posted_at' => 'nullable|date',
                'is_active' => 'boolean',
                'sort_order' => 'nullable|integer',
            ]);

            $dto = new ProductPostDTO($validated);
            $post = $this->productPostService->updateProductPost($id, $dto);

            return response()->json($post);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->productPostService->deleteProductPost($id);
            return response()->json(['message' => 'Xóa bài đăng thành công']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}