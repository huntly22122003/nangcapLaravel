<?php

namespace App\Services\Admin;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService implements UserServiceInterface
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getUsers(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->userRepo->all($filters, $perPage);
    }

    public function getUser(int $id): object
    {
        return $this->userRepo->find($id);
    }

    public function createUser(array $data): object
    {
        return $this->userRepo->create($data);
    }

    public function updateUser(int $id, array $data): object
    {
        return $this->userRepo->update($id, $data);
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepo->delete($id);
    }
}