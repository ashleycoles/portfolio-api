<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    public function flush(): JsonResponse
    {
        Cache::flush();

        return response()->json([
            'message' => 'Cache flushed',
        ]);
    }
}
