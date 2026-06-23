<?php

namespace App\Services\Interfaces;

use App\DTOs\ProductPostDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductPostServiceInterface
{
    public function getProductPosts(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function getProductPost(int $id): object;
    public function createProductPost(ProductPostDTO $dto): object;
    public function updateProductPost(int $id, ProductPostDTO $dto): object;
    public function deleteProductPost(int $id): bool;
}