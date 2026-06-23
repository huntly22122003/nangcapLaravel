<?php

namespace App\Services\Admin;

use App\DTOs\GalleryDTO;
use App\Repositories\Interfaces\GalleryRepositoryInterface;
use App\Services\Interfaces\GalleryServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class GalleryService implements GalleryServiceInterface
{
    protected $galleryRepo;

    public function __construct(GalleryRepositoryInterface $galleryRepo)
    {
        $this->galleryRepo = $galleryRepo;
    }

    public function getGalleries(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->galleryRepo->all($filters, $perPage);
    }

    public function getGallery(int $id): object
    {
        return $this->galleryRepo->find($id);
    }

    public function createGallery(GalleryDTO $dto): object
    {
        $data = $dto->toArray();

        // Xử lý upload ảnh
        if (isset($dto->image_file) && $dto->image_file instanceof \Illuminate\Http\UploadedFile) {
            $path = $dto->image_file->store('galleries', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        return $this->galleryRepo->create($data);
    }

    public function updateGallery(int $id, GalleryDTO $dto): object
    {
        $data = $dto->toArray();

        // Nếu có file mới thì upload và set image_path
        if (isset($dto->image_file) && $dto->image_file instanceof \Illuminate\Http\UploadedFile) {
            // xóa ảnh cũ
            $oldGallery = $this->galleryRepo->find($id);
            if ($oldGallery->image_path) {
                $oldPath = str_replace('/storage/', '', $oldGallery->image_path);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $path = $dto->image_file->store('galleries', 'public');
            $data['image_path'] = '/storage/' . $path;
        } else {
            // Không có file mới, không cập nhật image_path, lấy từ dữ liệu cũ bằng cách xóa khỏi mảng data
            unset($data['image_path']);
        }

        return $this->galleryRepo->update($id, $data);
    }

    public function deleteGallery(int $id): bool
    {
        // Xóa ảnh khi xóa gallery
        $gallery = $this->galleryRepo->find($id);
        if ($gallery->image_path) {
            $oldPath = str_replace('/storage/', '', $gallery->image_path);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        return $this->galleryRepo->delete($id);
    }
}