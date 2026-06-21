<?php

namespace App\Services\Admin;

use App\DTOs\ProductDTO;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getProducts(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->productRepo->all($filters, $perPage);
    }

    public function getProduct(int $id): object
    {
        return $this->productRepo->find($id);
    }

    public function createProduct(ProductDTO $dto): object
    {
        $data = $dto->toArray();
        // Xử lý upload ảnh nếu có
        if (isset($data['thumbnail_file'])) {
            $path = $data['thumbnail_file']->store('products', 'public');
            $data['thumbnail'] = '/storage/' . $path;
            unset($data['thumbnail_file']);
        }
        return $this->productRepo->create($data);
    }

    public function updateProduct(int $id, ProductDTO $dto): object
    {
        $data = $dto->toArray();
        if (isset($data['thumbnail_file'])) {
            $path = $data['thumbnail_file']->store('products', 'public');
            $data['thumbnail'] = '/storage/' . $path;
            unset($data['thumbnail_file']);
        }
        return $this->productRepo->update($id, $data);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepo->delete($id);
    }

    public function updateProductOrder(array $ids, array $orders): bool
    {
        return $this->productRepo->updateOrder($ids, $orders);
    }
}