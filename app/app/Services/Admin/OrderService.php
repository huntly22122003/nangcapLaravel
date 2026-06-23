<?php

namespace App\Services\Admin;

use App\DTOs\OrderDTO;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Services\Interfaces\OrderServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService implements OrderServiceInterface
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function getOrders(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->orderRepo->all($filters, $perPage);
    }

    public function getOrder(int $id): object
    {
        return $this->orderRepo->find($id);
    }

    public function createOrder(OrderDTO $dto): object
    {
        return $this->orderRepo->create($dto->toArray());
    }

    public function updateOrder(int $id, OrderDTO $dto): object
    {
        return $this->orderRepo->update($id, $dto->toArray());
    }

    public function deleteOrder(int $id): bool
    {
        return $this->orderRepo->delete($id);
    }

    public function updateOrderStatus(int $id, string $status): object
    {
        return $this->orderRepo->updateStatus($id, $status);
    }
}