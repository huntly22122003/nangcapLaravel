<?php

namespace App\Repositories\Eloquent;

use App\Models\Banner;
use App\Repositories\Interfaces\BannerRepositoryInterface;

class BannerRepository implements BannerRepositoryInterface
{
    protected $model;

    public function __construct(Banner $banner)
    {
        $this->model = $banner;
    }

    public function all(array $filters = [])
    {
        $query = $this->model->query();

        if (!empty($filters['position'])) {
            $query->where('position', $filters['position']);
        }

        return $query->orderBy('sort_order')->get();
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
        $banner = $this->find($id);
        $banner->update($data);
        return $banner;
    }

    public function delete(int $id)
    {
        $banner = $this->find($id);
        return $banner->delete();
    }
}