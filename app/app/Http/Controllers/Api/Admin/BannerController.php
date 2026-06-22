<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\BannerDTO;
use App\Services\Interfaces\BannerServiceInterface;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerServiceInterface $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['position']);
        $banners = $this->bannerService->getBanners($filters);
        return response()->json($banners);
    }

    public function show($id)
    {
        $banner = $this->bannerService->getBanner($id);
        return response()->json($banner);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'position' => 'required|string|in:1,2,3,4,5,6,7,8',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'image_file' => 'nullable|image|max:2048',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $dto = new BannerDTO($validated);
        if ($request->hasFile('image_file')) {
            $dto->image_file = $request->file('image_file');
        }

        $banner = $this->bannerService->createBanner($dto);
        return response()->json($banner, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|string|max:255',
            'position' => 'required|string|in:1,2,3,4,5,6,7,8',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'image_file' => 'nullable|image|max:2048',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $dto = new BannerDTO($validated);
        if ($request->hasFile('image_file')) {
            $dto->image_file = $request->file('image_file');
        }

        $banner = $this->bannerService->updateBanner($id, $dto);
        return response()->json($banner);
    }

    public function destroy($id)
    {
        $this->bannerService->deleteBanner($id);
        return response()->json(['message' => 'Xóa thành công']);
    }
}