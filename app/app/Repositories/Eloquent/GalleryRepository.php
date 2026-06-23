<?php

namespace App\Repositories\Eloquent;

use App\Models\Gallery;
use App\Repositories\Interfaces\GalleryRepositoryInterface;

class GalleryRepository implements GalleryRepositoryInterface
{
    protected $model;

    public function __construct(Gallery $gallery)
    {
        $this->model = $gallery;
    }

    public function all(array $filters = [], int $perPage = 20)
    {
        $query = $this->model->query();

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['is_active'])) {
            $query->where('is_active', (bool)$filters['is_active']);
        }

        return $query->orderBy('sort_order')->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $gallery = $this->find($id);
        $gallery->update($data);
        return $gallery;
    }

    public function delete(int $id)
    {
        $gallery = $this->find($id);
        return $gallery->delete();
    }
}