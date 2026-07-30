<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUploadService
{
    /**
     * Resize (if wider than $maxWidth) and compress an uploaded image to
     * WebP before storing it. WebP at 78% quality is typically 60-80%
     * smaller than the original JPEG/PNG with no visible quality loss at
     * the sizes this site actually displays images — this is the single
     * biggest lever for keeping the site fast as the catalogue grows.
     */
    public static function store(UploadedFile $file, string $directory, int $maxWidth = 1200, int $quality = 78): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        if ($image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        $encoded = $image->toWebp($quality);

        $filename = $directory.'/'.Str::random(20).'.webp';
        Storage::disk('public')->put($filename, (string) $encoded);

        return Storage::url($filename);
    }
}