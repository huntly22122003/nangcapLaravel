<?php

namespace App\Services\Admin;

use App\DTOs\FaqDTO;
use App\Repositories\Interfaces\FaqRepositoryInterface;
use App\Services\Interfaces\FaqServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class FaqService implements FaqServiceInterface
{
    protected $faqRepo;

    public function __construct(FaqRepositoryInterface $faqRepo)
    {
        $this->faqRepo = $faqRepo;
    }

    public function getFaqs(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->faqRepo->all($filters, $perPage);
    }

    public function getFaq(int $id): object
    {
        return $this->faqRepo->find($id);
    }

    public function createFaq(FaqDTO $dto): object
    {
        return $this->faqRepo->create($dto->toArray());
    }

    public function updateFaq(int $id, FaqDTO $dto): object
    {
        return $this->faqRepo->update($id, $dto->toArray());
    }

    public function deleteFaq(int $id): bool
    {
        return $this->faqRepo->delete($id);
    }
}