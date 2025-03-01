<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Jobs\RefreshPostsCache;
use App\Models\Post;
use App\Services\ImageService;
use App\Services\PostsCacheService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function all(PostsCacheService $postsCacheService): JsonResponse
    {
        $posts = $postsCacheService->getPosts();

        return response()->json([
            'data' => $posts,
        ]);
    }

    public function find(string $slug, PostsCacheService $postsCacheService): JsonResponse
    {
        $post = $postsCacheService->getPost($slug);

        if (! $post) {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

        return response()->json([
            'data' => $post,
        ]);
    }

    public function store(CreatePostRequest $request, ImageService $imageService): JsonResponse
    {
        $post = Post::create($request->except('featuredImage'));

        if ($request->hasFile('featuredImage')) {
            $imageUrl = $imageService->store($request->file('featuredImage'));

            if (! $imageUrl) {
                Log::error('Failed to upload featured image');

                $post->delete();

                return response()->json([
                    'message' => 'Post creation failed',
                ], 500);
            }

            $post->update(['featuredImage' => $imageUrl]);
        }

        RefreshPostsCache::dispatch();

        return response()->json([
            'message' => 'Post created',
        ], 201);
    }
}
