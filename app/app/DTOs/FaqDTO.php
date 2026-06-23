<?php

namespace App\DTOs;

class FaqDTO
{
    public string $question;
    public ?string $answer;
    public int $sort_order;
    public bool $is_active;

    public function __construct(array $data)
    {
        $this->question = $data['question'] ?? '';
        $this->answer = $data['answer'] ?? null;
        $this->sort_order = $data['sort_order'] ?? 0;
        $this->is_active = $data['is_active'] ?? true;
    }

    public function toArray(): array
    {
        return [
            'question' => $this->question,
            'answer' => $this->answer,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];
    }
}