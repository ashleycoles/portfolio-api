<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function all(): JsonResponse
    {
        $posts = Cache::rememberForever('posts', function () {
            Log::info('Caching posts');
            return Post::select(['id', 'title', 'featuredImage'])->get();
        });

        return response()->json([
            'data' => $posts,
        ]);
    }

    public function store(CreatePostRequest $request, ImageService $imageService): JsonResponse
    {
        $post = Post::create($request->except('featuredImage'));

        if ($request->hasFile('featuredImage')) {
            $imageUrl = $imageService->store($request->file('featuredImage'));

            if (!$imageUrl) {
                Log::error('Failed to upload featured image');

                $post->delete();

                return response()->json([
                    'message' => 'Post creation failed'
                ], 500);
            }

            $post->update(['featuredImage' => $imageUrl]);
        }

        Cache::forget('posts');

        return response()->json([
            'message' => 'Post created'
        ], 201);
    }
}
