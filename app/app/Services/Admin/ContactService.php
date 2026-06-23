<?php

namespace App\Services\Admin;

use App\DTOs\ContactDTO;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use App\Services\Interfaces\ContactServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactService implements ContactServiceInterface
{
    protected $contactRepo;

    public function __construct(ContactRepositoryInterface $contactRepo)
    {
        $this->contactRepo = $contactRepo;
    }

    public function getContacts(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->contactRepo->all($filters, $perPage);
    }

    public function getContact(int $id): object
    {
        return $this->contactRepo->find($id);
    }

    public function createContact(ContactDTO $dto): object
    {
        return $this->contactRepo->create($dto->toArray());
    }

    public function updateContact(int $id, ContactDTO $dto): object
    {
        return $this->contactRepo->update($id, $dto->toArray());
    }

    public function deleteContact(int $id): bool
    {
        return $this->contactRepo->delete($id);
    }
}