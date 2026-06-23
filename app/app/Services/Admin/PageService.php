<?php

namespace App\Services\Admin;

use App\DTOs\PageDTO;
use App\Repositories\Interfaces\PageRepositoryInterface;
use App\Services\Interfaces\PageServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PageService implements PageServiceInterface
{
    protected $pageRepo;

    public function __construct(PageRepositoryInterface $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }

    public function getPages(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->pageRepo->all($filters, $perPage);
    }

    public function getPage(int $id): object
    {
        return $this->pageRepo->find($id);
    }

    public function getPageBySlug(string $slug): object
    {
        return $this->pageRepo->findBySlug($slug);
    }

    public function createPage(PageDTO $dto): object
    {
        return $this->pageRepo->create($dto->toArray());
    }

    public function updatePage(int $id, PageDTO $dto): object
    {
        return $this->pageRepo->update($id, $dto->toArray());
    }

    public function deletePage(int $id): bool
    {
        return $this->pageRepo->delete($id);
    }
}