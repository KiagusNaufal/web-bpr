<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait ResolvesMediaUrl
{
    /** Path absolut ("/images/..") dan URL eksternal dipakai apa adanya; selebihnya dari disk publik. */
    protected function mediaUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return str_starts_with($path, 'http') || str_starts_with($path, '/') ? $path : Storage::url($path);
    }
}
