<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class GalleryDTO
{
    public string $title;
    public ?string $image_path;
    public ?UploadedFile $image_file;
    public ?string $description;
    public int $sort_order;
    public bool $is_active;

    public function __construct(array $data)
    {
        $this->title = $data['title'] ?? '';
        $this->image_path = $data['image_path'] ?? null;
        $this->image_file = $data['image_file'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->sort_order = $data['sort_order'] ?? 0;
        $this->is_active = $data['is_active'] ?? true;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'image_path' => $this->image_path,
            'description' => $this->description,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];
    }
}