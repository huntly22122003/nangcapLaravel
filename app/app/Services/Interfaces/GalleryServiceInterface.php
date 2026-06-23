<?php

namespace App\Services\Interfaces;

use App\DTOs\GalleryDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface GalleryServiceInterface
{
    public function getGalleries(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function getGallery(int $id): object;
    public function createGallery(GalleryDTO $dto): object;
    public function updateGallery(int $id, GalleryDTO $dto): object;
    public function deleteGallery(int $id): bool;
}