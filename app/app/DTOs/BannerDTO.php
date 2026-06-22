<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class BannerDTO
{
    public ?string $title;
    public ?string $link;
    public ?string $position;
    public ?string $summary;
    public ?string $content;
    public ?UploadedFile $image_file;
    public ?string $image_path;
    public int $sort_order;
    public bool $is_active;

    public function __construct(array $data)
    {
        $this->title = $data['title'] ?? null;
        $this->link = $data['link'] ?? null;
        $this->position = $data['position'] ?? '1';
        $this->summary = $data['summary'] ?? null;
        $this->content = $data['content'] ?? null;
        $this->image_file = $data['image_file'] ?? null;
        $this->image_path = $data['image_path'] ?? null;
        $this->sort_order = $data['sort_order'] ?? 0;
        $this->is_active = $data['is_active'] ?? true;
    }

    public function toArray(): array
    {
        $array = get_object_vars($this);
        unset($array['image_file']);
        return $array;
    }
}