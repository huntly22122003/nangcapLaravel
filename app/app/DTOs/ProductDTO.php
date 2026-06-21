<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class ProductDTO
{
    public ?int $category_id;
    public string $name;
    public ?string $extraname;
    public string $slug;
    public ?string $code;
    public ?float $price;
    public ?string $brand;
    public ?string $origin;
    public ?string $model_no;
    public ?string $summary;
    public ?string $description;
    public ?string $technic_info;
    public ?string $thumbnail;
    public ?UploadedFile $thumbnail_file;
    public bool $is_new;
    public bool $is_featured;
    public bool $has_gallery;
    public int $sort_order;
    public bool $is_active;

    public function __construct(array $data)
    {
        $this->category_id = $data['category_id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->extraname = $data['extraname'] ?? null;
        $this->slug = $data['slug'] ?? \Str::slug($data['name'] ?? '');
        $this->code = $data['code'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->brand = $data['brand'] ?? null;
        $this->origin = $data['origin'] ?? null;
        $this->model_no = $data['model_no'] ?? null;
        $this->summary = $data['summary'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->technic_info = $data['technic_info'] ?? null;
        $this->thumbnail = $data['thumbnail'] ?? null;
        $this->thumbnail_file = $data['thumbnail_file'] ?? null;
        $this->is_new = $data['is_new'] ?? false;
        $this->is_featured = $data['is_featured'] ?? false;
        $this->has_gallery = $data['has_gallery'] ?? false;
        $this->sort_order = $data['sort_order'] ?? 0;
        $this->is_active = $data['is_active'] ?? true;
    }

    public function toArray(): array
    {
        return [
            'category_id' => $this->category_id,
            'name' => $this->name,
            'extraname' => $this->extraname,
            'slug' => $this->slug,
            'code' => $this->code,
            'price' => $this->price,
            'brand' => $this->brand,
            'origin' => $this->origin,
            'model_no' => $this->model_no,
            'summary' => $this->summary,
            'description' => $this->description,
            'technic_info' => $this->technic_info,
            'thumbnail' => $this->thumbnail,
            'is_new' => $this->is_new,
            'is_featured' => $this->is_featured,
            'has_gallery' => $this->has_gallery,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];
    }
}