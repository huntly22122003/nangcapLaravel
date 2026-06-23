<?php

namespace App\Services\Interfaces;

use App\DTOs\ContactDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface ContactServiceInterface
{
    public function getContacts(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function getContact(int $id): object;
    public function createContact(ContactDTO $dto): object;
    public function updateContact(int $id, ContactDTO $dto): object;
    public function deleteContact(int $id): bool;
}