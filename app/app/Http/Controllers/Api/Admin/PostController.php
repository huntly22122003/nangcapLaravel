<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\PostDTO;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'search', 'is_active']);
        $perPage = $request->input('per_page', 20);

        $posts = $this->postService->getPosts($filters, $perPage);
        return response()->json($posts);
    }

    public function show($id)
    {
        try {
            $post = $this->postService->getPost($id);
            return response()->json($post);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Bài viết không tồn tại'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_id' => 'nullable|exists:categories,id',
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:posts,slug',
                'summary' => 'nullable|string',
                'content' => 'nullable|string',
                'thumbnail_file' => 'nullable|image|max:2048',
                'published_at' => [
                    'nullable',
                    'date_format:Y-m-d',
                    'after:1900-01-01',
                    'before:2099-12-31',
                ],
                'is_active' => 'boolean',
            ]);

            $dto = new PostDTO($validated);
            $post = $this->postService->createPost($dto);

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
                'category_id' => 'nullable|exists:categories,id',
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:posts,slug,' . $id,
                'summary' => 'nullable|string',
                'content' => 'nullable|string',
                'thumbnail_file' => 'nullable|image|max:2048',
                'published_at' => [
                    'nullable',
                    'date_format:Y-m-d',
                    'after:1900-01-01',
                    'before:2099-12-31',
                ],
                'is_active' => 'boolean',
            ]);

            $dto = new PostDTO($validated);
            $post = $this->postService->updatePost($id, $dto);

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
            $this->postService->deletePost($id);
            return response()->json(['message' => 'Xóa bài viết thành công']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}