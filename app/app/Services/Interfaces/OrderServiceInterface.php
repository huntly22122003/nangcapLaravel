<?php

namespace App\Services\Interfaces;

use App\DTOs\OrderDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface OrderServiceInterface
{
    public function getOrders(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function getOrder(int $id): object;
    public function createOrder(OrderDTO $dto): object;
    public function updateOrder(int $id, OrderDTO $dto): object;
    public function deleteOrder(int $id): bool;
    public function updateOrderStatus(int $id, string $status): object;
}