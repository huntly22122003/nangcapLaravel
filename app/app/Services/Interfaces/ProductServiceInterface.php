<?php

namespace App\Services\Interfaces;

use App\DTOs\ProductDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function getProducts(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function getProduct(int $id): object;
    public function createProduct(ProductDTO $dto): object;
    public function updateProduct(int $id, ProductDTO $dto): object;
    public function deleteProduct(int $id): bool;
    public function updateProductOrder(array $ids, array $orders): bool;
}