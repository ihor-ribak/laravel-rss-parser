<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostRepository
{
    /**
     * Get a list of posts with filtering and pagination.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPosts(array $filters): LengthAwarePaginator
    {
        $query = Post::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('link', 'like', '%' . $filters['search'] . '%');
            });
        }

        $sortBy = $filters['sort_by'] ?? 'id';
        $sortOrder = $filters['sort_order'] ?? 'asc';

        if (in_array($sortBy, ['id', 'title', 'link', 'description', 'pub_date', 'created_at', 'updated_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = (int) ($filters['per_page'] ?? 10);
        $page = (int) ($filters['page'] ?? 1);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Create a new post.
     *
     * @param array $data
     * @return Post
     */
    public function createPost(array $data): Post
    {
        return Post::create($data);
    }

    /**
     * Update a post.
     *
     * @param Post $post
     * @param array $data
     * @return bool
     */
    public function updatePost(Post $post, array $data): bool
    {
        return $post->update($data);
    }

    /**
     * Delete a post.
     *
     * @param Post $post
     * @return bool|null
     */
    public function deletePost(Post $post): ?bool
    {
        return $post->delete();
    }

    /**
     * Create or update post by guid
     *
     * @param string $guid
     * @param array $data
     * @return Post
     */
    public function updateOrCreatePost(string $guid, array $data): Post
    {
        return Post::updateOrCreate(
            ['guid' => $guid],
            $data
        );
    }
}
