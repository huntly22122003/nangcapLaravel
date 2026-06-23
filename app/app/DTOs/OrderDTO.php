<?php

namespace App\DTOs;

class OrderDTO
{
    public ?int $customer_id;
    public string $status;
    public float $total_amount;
    public ?string $note;

    public function __construct(array $data)
    {
        $this->customer_id = $data['customer_id'] ?? null;
        $this->status = $data['status'] ?? 'new';
        $this->total_amount = $data['total_amount'] ?? 0;
        $this->note = $data['note'] ?? null;
    }

    public function toArray(): array
    {
        return [
            'customer_id' => $this->customer_id,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'note' => $this->note,
        ];
    }
}