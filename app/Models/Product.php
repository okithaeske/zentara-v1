<?php

namespace App\Models;

use App\Models\OrderItem;
use Aws\Exception\InvalidRegionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'sku',
        'price',
        'stock',
        'description',
        'image_path',
        'status',
    ];

    protected $appends = [
        'image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        $path = $this->image_path;

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