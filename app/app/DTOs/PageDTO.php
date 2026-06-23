<?php

namespace App\DTOs;

use Illuminate\Support\Str;

class PageDTO
{
    public string $title;
    public string $slug;
    public ?string $summary;
    public ?string $content;
    public bool $is_active;

    public function __construct(array $data)
    {
        $this->title = $data['title'] ?? '';
        $this->slug = $data['slug'] ?? Str::slug($data['title'] ?? '');
        $this->summary = $data['summary'] ?? null;
        $this->content = $data['content'] ?? null;
        $this->is_active = $data['is_active'] ?? true;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content' => $this->content,
            'is_active' => $this->is_active,
        ];
    }
}