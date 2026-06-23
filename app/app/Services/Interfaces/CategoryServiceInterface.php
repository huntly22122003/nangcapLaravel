<?php

namespace App\Services\Interfaces;

interface CategoryServiceInterface
{
    public function getCategories();
    public function getCategory(int $id);
    public function createCategory(array $data);
    public function updateCategory(int $id, array $data);
    public function deleteCategory(int $id);
}