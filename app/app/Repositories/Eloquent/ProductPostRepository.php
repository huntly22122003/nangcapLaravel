<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductPost;
use App\Repositories\Interfaces\ProductPostRepositoryInterface;

class ProductPostRepository implements ProductPostRepositoryInterface
{
    protected $model;

    public function __construct(ProductPost $productPost)
    {
        $this->model = $productPost;
    }

    public function all(array $filters = [], int $perPage = 20)
    {
        $query = $this->model->with('product');

        if (!empty($filters['search'])) {
            $query->whereHas('product', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['is_active'])) {
            $query->where('is_active', (bool)$filters['is_active']);
        }

        return $query->orderBy('sort_order')->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->with('product')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $post = $this->find($id);
        $post->update($data);
        return $post;
    }

    public function delete(int $id)
    {
        $post = $this->find($id);
        return $post->delete();
    }
}