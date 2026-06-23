<?php

namespace App\Services\Interfaces;

use App\DTOs\PageDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface PageServiceInterface
{
    public function getPages(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function getPage(int $id): object;
    public function getPageBySlug(string $slug): object;
    public function createPage(PageDTO $dto): object;
    public function updatePage(int $id, PageDTO $dto): object;
    public function deletePage(int $id): bool;
}