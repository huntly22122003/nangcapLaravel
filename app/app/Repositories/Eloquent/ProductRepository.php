<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function all(array $filters = [], int $perPage = 20)
    {
        $query = $this->model->with('category');

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['is_new'])) {
            $query->where('is_new', true);
        }

        if (!empty($filters['is_featured'])) {
            $query->where('is_featured', true);
        }

        return $query->orderBy('sort_order')->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->with('category')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        $product = $this->find($id);
        return $product->delete();
    }

    public function updateOrder(array $ids, array $orders)
    {
        foreach ($ids as $index => $id) {
            $this->model->where('id', $id)->update(['sort_order' => $orders[$index] ?? 0]);
        }
        return true;
    }
}