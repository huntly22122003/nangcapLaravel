<?php

namespace App\Services\Interfaces;

use App\DTOs\BannerDTO;

interface BannerServiceInterface
{
    public function getBanners(array $filters = []);
    public function getBanner(int $id);
    public function createBanner(BannerDTO $dto);
    public function updateBanner(int $id, BannerDTO $dto);
    public function deleteBanner(int $id);
}