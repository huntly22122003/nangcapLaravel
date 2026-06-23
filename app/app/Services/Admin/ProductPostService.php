<?php

namespace App\Services\Admin;

use App\DTOs\ProductPostDTO;
use App\Repositories\Interfaces\ProductPostRepositoryInterface;
use App\Services\Interfaces\ProductPostServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductPostService implements ProductPostServiceInterface
{
    protected $postRepo;

    public function __construct(ProductPostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function getProductPosts(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->postRepo->all($filters, $perPage);
    }

    public function getProductPost(int $id): object
    {
        return $this->postRepo->find($id);
    }

    public function createProductPost(ProductPostDTO $dto): object
    {
        $data = $dto->toArray();
        if (empty($data['posted_at'])) {
            $data['posted_at'] = now();
        }
        return $this->postRepo->create($data);
    }

    public function updateProductPost(int $id, ProductPostDTO $dto): object
    {
        return $this->postRepo->update($id, $dto->toArray());
    }

    public function deleteProductPost(int $id): bool
    {
        return $this->postRepo->delete($id);
    }
}