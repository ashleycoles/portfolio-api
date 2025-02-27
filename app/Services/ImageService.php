<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function store(UploadedFile $image): string|false
    {
            $fileName = time() . '_' . $image->getClientOriginalName();

            $path = $image->storeAs('images', $fileName);

            return !$path ? false : Storage::url($path);
    }
}
