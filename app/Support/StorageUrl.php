<?php

namespace App\Support;

use Aws\Exception\InvalidRegionException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class StorageUrl
{
    public static function for(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $normalized = ltrim($path, '/');
        if (Str::startsWith($normalized, 'storage/')) {
            $normalized = Str::after($normalized, 'storage/');
        }

        $disks = array_filter(array_unique([
            'public',
            config('filesystems.default'),
        ]));

        foreach ($disks as $disk) {
            try {
                $storage = Storage::disk($disk);
                $url = $storage->url($normalized);

                if ($url) {
                    return Str::startsWith($url, ['http://', 'https://']) ? $url : url($url);
                }
            } catch (InvalidArgumentException|InvalidRegionException $exception) {
                continue;
            }
        }

        return asset('storage/' . $normalized);
    }
}