<?php

namespace App\DTOs;

class ProductPostDTO
{
    public int $product_id;
    public ?string $content;
    public ?string $posted_at;
    public bool $is_active;
    public int $sort_order;

    public function __construct(array $data)
    {
        $this->product_id = $data['product_id'] ?? 0;
        $this->content = $data['content'] ?? null;
        $this->posted_at = $data['posted_at'] ?? null;
        $this->is_active = $data['is_active'] ?? true;
        $this->sort_order = $data['sort_order'] ?? 0;
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'content' => $this->content,
            'posted_at' => $this->posted_at,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];
    }
}