<?php

namespace App\Services\Admin;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use Illuminate\Support\Str;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function getCategories()
    {
        return $this->categoryRepo->all();
    }

    public function getCategory(int $id)
    {
        return $this->categoryRepo->find($id);
    }

    public function createCategory(array $data)
    {
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        return $this->categoryRepo->create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        $category = $this->categoryRepo->find($id);
        
        // Nếu tên thay đổi, tạo slug mới (đảm bảo unique)
        if (isset($data['name']) && $data['name'] !== $category->name) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $id);
        } else {
            // Giữ nguyên slug cũ nếu tên không đổi
            unset($data['slug']);
        }
        
        return $this->categoryRepo->update($id, $data);
    }

    public function deleteCategory(int $id)
    {
        return $this->categoryRepo->delete($id);
    }

    /**
     * Tạo slug unique, tránh trùng lặp
     */
    private function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        // Kiểm tra slug đã tồn tại chưa (loại trừ category hiện tại khi update)
        while ($this->slugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Kiểm tra slug đã tồn tại trong database chưa
     */
    private function slugExists(string $slug, ?int $excludeId = null): bool
    {
        $query = \App\Models\Category::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->exists();
    }
}