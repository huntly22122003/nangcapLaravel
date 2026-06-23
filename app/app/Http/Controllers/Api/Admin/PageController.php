<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\PageDTO;
use App\Services\Interfaces\PageServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PageController extends Controller
{
    protected $pageService;

    public function __construct(PageServiceInterface $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'is_active']);
        $perPage = $request->input('per_page', 20);

        $pages = $this->pageService->getPages($filters, $perPage);
        return response()->json($pages);
    }

    public function show($id)
    {
        try {
            $page = $this->pageService->getPage($id);
            return response()->json($page);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Không tìm thấy trang'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:pages,slug',
                'summary' => 'nullable|string',
                'content' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            $dto = new PageDTO($validated);
            $page = $this->pageService->createPage($dto);

            return response()->json($page, 201);
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
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:pages,slug,' . $id,
                'summary' => 'nullable|string',
                'content' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            $dto = new PageDTO($validated);
            $page = $this->pageService->updatePage($id, $dto);

            return response()->json($page);
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
            $this->pageService->deletePage($id);
            return response()->json(['message' => 'Xóa trang thành công']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}