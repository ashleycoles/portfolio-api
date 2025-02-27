<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

    public function store(CreatePostRequest $request): JsonResponse
    {
        $post = Post::create($request->except('featuredImage'));

        if ($request->hasFile('featuredImage')) {
            try {
                $image = $request->file('featuredImage');
                $fileName = time() . '_' . $image->getClientOriginalName();

                $path = $image->storeAs('images', $fileName);

                $post->update(['featuredImage', $path]);
            } catch (\Exception $e) {
                Log::error('Failed to upload featured image: ' . $e->getMessage());

                $post->delete();

                return response()->json([
                    'message' => 'Post creation failed'
                ], 500);
            }
        }

        return response()->json([
            'message' => 'Post created'
        ], 201);
    }
}
