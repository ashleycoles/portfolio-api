<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\PostsCacheService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RefreshPostsCache implements ShouldQueue
{
    use Queueable;

    public function handle(PostsCacheService $postsCacheService): void
    {
        Log::info('Running RefreshPostsCache');

        $postsCacheService->refreshCache();
    }
}
