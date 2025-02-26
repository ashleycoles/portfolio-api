<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function all(): JsonResponse
    {
        $posts = Post::select(['id', 'title', 'featuredImage'])->get();

        return response()->json([
            'data' => $posts,
        ]);
    }
}
