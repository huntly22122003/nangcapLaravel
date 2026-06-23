<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class PostDTO
{
    public ?int $category_id;
    public string $title;
    public string $slug;
    public ?string $summary;
    public ?string $content;
    public ?string $thumbnail;
    public ?UploadedFile $thumbnail_file;
    public ?string $published_at;
    public bool $is_active;

    public function __construct(array $data)
    {
        $this->category_id = $data['category_id'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->slug = $data['slug'] ?? Str::slug($data['title'] ?? '');
        $this->summary = $data['summary'] ?? null;
        $this->content = $data['content'] ?? null;
        $this->thumbnail = $data['thumbnail'] ?? null;
        $this->thumbnail_file = $data['thumbnail_file'] ?? null;
        $this->published_at = $data['published_at'] ?? null;
        $this->is_active = $data['is_active'] ?? true;
    }

    public function toArray(): array
    {
        return [
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content' => $this->content,
            'thumbnail' => $this->thumbnail,
            'published_at' => $this->published_at,
            'is_active' => $this->is_active,
        ];
    }
}