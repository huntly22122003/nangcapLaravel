<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\GalleryDTO;
use App\Services\Interfaces\GalleryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GalleryController extends Controller
{
    protected $galleryService;

    public function __construct(GalleryServiceInterface $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'is_active']);
        $perPage = $request->input('per_page', 20);

        $galleries = $this->galleryService->getGalleries($filters, $perPage);
        return response()->json($galleries);
    }

    public function show($id)
    {
        try {
            $gallery = $this->galleryService->getGallery($id);
            return response()->json($gallery);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Không tìm thấy ảnh'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image_file' => 'required|image|max:5120', // 5MB
                'description' => 'nullable|string',
                'sort_order' => 'nullable|integer',
                'is_active' => 'boolean',
            ]);

            $dto = new GalleryDTO($validated);
            $gallery = $this->galleryService->createGallery($dto);

            return response()->json($gallery, 201);
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
                'image_file' => 'nullable|image|max:5120',
                'description' => 'nullable|string',
                'sort_order' => 'nullable|integer',
                'is_active' => 'boolean',
            ]);

            $dto = new GalleryDTO($validated);
            $gallery = $this->galleryService->updateGallery($id, $dto);

            return response()->json($gallery);
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
            $this->galleryService->deleteGallery($id);
            return response()->json(['message' => 'Xóa ảnh thành công']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}