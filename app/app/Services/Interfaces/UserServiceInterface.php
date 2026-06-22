<?php

namespace App\Services\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function getUsers(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function getUser(int $id): object;
    public function createUser(array $data): object;
    public function updateUser(int $id, array $data): object;
    public function deleteUser(int $id): bool;
}