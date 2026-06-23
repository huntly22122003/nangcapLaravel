<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 20);
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function updateStatus(int $id, string $status);
}