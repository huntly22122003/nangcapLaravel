<?php

namespace App\Services\Interfaces;

use App\DTOs\PostDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostServiceInterface
{
    public function getPosts(array $filters = [], int $perPage = 20): LengthAwarePaginator;
    public function getPost(int $id): object;
    public function createPost(PostDTO $dto): object;
    public function updatePost(int $id, PostDTO $dto): object;
    public function deletePost(int $id): bool;
}