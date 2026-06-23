<?php

namespace App\Repositories\Eloquent;

use App\Models\Page;
use App\Repositories\Interfaces\PageRepositoryInterface;

class PageRepository implements PageRepositoryInterface
{
    protected $model;

    public function __construct(Page $page)
    {
        $this->model = $page;
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

        return $query->orderBy('id')->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $page = $this->find($id);
        $page->update($data);
        return $page;
    }

    public function delete(int $id)
    {
        $page = $this->find($id);
        return $page->delete();
    }
}