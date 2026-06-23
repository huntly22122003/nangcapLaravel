<?php

namespace App\Services\Interfaces;

use App\DTOs\FaqDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface FaqServiceInterface
{
    public function getFaqs(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function getFaq(int $id): object;
    public function createFaq(FaqDTO $dto): object;
    public function updateFaq(int $id, FaqDTO $dto): object;
    public function deleteFaq(int $id): bool;
}