<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PostsCacheService
{
    public function getPosts()
    {
        return Cache::rememberForever('posts', function () {
            Log::info('Caching posts');

            return Post::select(['id', 'title', 'slug', 'featuredImage', 'excerpt'])->get();
        });
    }

    public function getPost(string $slug)
    {
        return Cache::rememberForever("posts.$slug", function () use ($slug) {
            Log::info("Caching post: $slug");

            return Post::select(['id', 'title', 'slug', 'featuredImage', 'excerpt', 'content'])
                ->where('slug', $slug)
                ->first();
        });
    }

    public function refreshCache(): void
    {
        Cache::forget('posts');

        $this->getPosts();
    }
}
