<?php

namespace App\Support;

use Aws\Exception\InvalidRegionException;
use Illuminate\Filesystem\FilesystemAdapter;
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

        $normalized = self::normalizePath($path);

        if ($normalized) {
            $disks = array_filter(array_unique([
                'public',
                config('filesystems.default'),
            ]));

            foreach ($disks as $disk) {
                try {
                    /** @var FilesystemAdapter $storage */
                    $storage = Storage::disk($disk);
                    $url = $storage->url($normalized);

                    if ($url) {
                        return Str::startsWith($url, ['http://', 'https://']) ? $url : url($url);
                    }
                } catch (InvalidArgumentException|InvalidRegionException $exception) {
                    continue;
                }
            }
        }

        if (Str::startsWith($path, 's3://')) {
            return self::fromS3Uri($path);
        }

        return $normalized ? asset('storage/' . $normalized) : null;
    }

    public static function normalizePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $value = trim($path);

        if (Str::startsWith($value, 's3://')) {
            $withoutScheme = Str::after($value, 's3://');
            [$maybeBucket, $key] = explode('/', $withoutScheme, 2) + [null, null];
            $value = $key ?? $maybeBucket ?? '';
        }

        $value = ltrim($value, '/');

        if (Str::startsWith($value, 'storage/')) {
            $value = Str::after($value, 'storage/');
        }

        return $value !== '' ? $value : null;
    }

    protected static function fromS3Uri(string $uri): string
    {
        $withoutScheme = Str::after($uri, 's3://');
        [$bucket, $key] = explode('/', $withoutScheme, 2) + [null, null];

        $bucket = $bucket ?: env('AWS_BUCKET');
        $key = $key ? ltrim($key, '/') : '';

        if (!$bucket || $key === '') {
            return $uri;
        }

        $region = env('AWS_DEFAULT_REGION', 'us-east-1');

        $host = $region === 'us-east-1'
            ? sprintf('%s.s3.amazonaws.com', $bucket)
            : sprintf('%s.s3.%s.amazonaws.com', $bucket, $region);

        $encodedKey = implode('/', array_map('rawurlencode', explode('/', $key)));

        return sprintf('https://%s/%s', $host, $encodedKey);
    }
}