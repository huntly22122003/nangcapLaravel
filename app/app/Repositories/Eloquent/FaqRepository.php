<?php

namespace App\Repositories\Eloquent;

use App\Models\Faq;
use App\Repositories\Interfaces\FaqRepositoryInterface;

class FaqRepository implements FaqRepositoryInterface
{
    protected $model;

    public function __construct(Faq $faq)
    {
        $this->model = $faq;
    }

    public function all(array $filters = [], int $perPage = 20)
    {
        $query = $this->model->query();

        if (!empty($filters['search'])) {
            $query->where('question', 'like', '%' . $filters['search'] . '%');
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
        $faq = $this->find($id);
        $faq->update($data);
        return $faq;
    }

    public function delete(int $id)
    {
        $faq = $this->find($id);
        return $faq->delete();
    }
}