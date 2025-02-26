<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function all(): JsonResponse
    {
        return response()->json([
            'data' => Post::all(),
        ]);
    }
}
