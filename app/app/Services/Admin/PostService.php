<?php

namespace App\Services\Admin;

use App\DTOs\PostDTO;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class PostService implements PostServiceInterface
{
    protected $postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function getPosts(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return $this->postRepo->all($filters, $perPage);
    }

    public function getPost(int $id): object
    {
        return $this->postRepo->find($id);
    }

    public function createPost(PostDTO $dto): object
    {
        $data = $dto->toArray();

        // Xử lý upload thumbnail
        if (isset($dto->thumbnail_file) && $dto->thumbnail_file instanceof \Illuminate\Http\UploadedFile) {
            $path = $dto->thumbnail_file->store('posts', 'public');
            // Lưu đường dẫn đầy đủ
            $data['thumbnail'] = '/storage/' . $path;
        }

        // Nếu không có published_at thì set là now
        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $this->postRepo->create($data);
    }

    public function updatePost(int $id, PostDTO $dto): object
    {
        $data = $dto->toArray();

        if (isset($dto->thumbnail_file) && $dto->thumbnail_file instanceof \Illuminate\Http\UploadedFile) {
            // Xóa ảnh cũ nếu có
            $oldPost = $this->postRepo->find($id);
            if ($oldPost->thumbnail) {
                $oldPath = str_replace('/storage/', '', $oldPost->thumbnail);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $path = $dto->thumbnail_file->store('posts', 'public');
            $data['thumbnail'] = '/storage/' . $path;
        }

        return $this->postRepo->update($id, $data);
    }

    public function deletePost(int $id): bool
    {
        // Xóa ảnh khi xóa bài viết
        $post = $this->postRepo->find($id);
        if ($post->thumbnail) {
            $oldPath = str_replace('/storage/', '', $post->thumbnail);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        return $this->postRepo->delete($id);
    }
}