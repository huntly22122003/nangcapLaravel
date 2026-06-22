<?php

namespace App\Services\Admin;

use App\DTOs\BannerDTO;
use App\Repositories\Interfaces\BannerRepositoryInterface;
use App\Services\Interfaces\BannerServiceInterface;

class BannerService implements BannerServiceInterface
{
    protected $bannerRepo;

    public function __construct(BannerRepositoryInterface $bannerRepo)
    {
        $this->bannerRepo = $bannerRepo;
    }

    public function getBanners(array $filters = [])
    {
        return $this->bannerRepo->all($filters);
    }

    public function getBanner(int $id)
    {
        return $this->bannerRepo->find($id);
    }

    public function createBanner(BannerDTO $dto)
    {
        $data = $dto->toArray();
        if ($dto->image_file) {
            $path = $dto->image_file->store('banners', 'public');
            $data['image_path'] = '/storage/' . $path;
        }
        return $this->bannerRepo->create($data);
    }

    public function updateBanner(int $id, BannerDTO $dto)
    {
        $data = $dto->toArray();
        if ($dto->image_file) {
            $path = $dto->image_file->store('banners', 'public');
            $data['image_path'] = '/storage/' . $path;
        }
        return $this->bannerRepo->update($id, $data);
    }

    public function deleteBanner(int $id)
    {
        return $this->bannerRepo->delete($id);
    }
}