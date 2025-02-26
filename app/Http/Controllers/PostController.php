<?php

namespace App\Http\Controllers;

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
}
