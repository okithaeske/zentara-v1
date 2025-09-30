<?php

namespace App\Models;

use App\Models\OrderItem;
use App\Support\StorageUrl;
use Aws\Exception\InvalidRegionException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
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

    protected function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => StorageUrl::normalizePath($value),
            set: fn ($value) => StorageUrl::normalizePath($value)
        );
    }

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

        try {
            return Storage::url($path);
        } catch (InvalidArgumentException|InvalidRegionException) {
            return StorageUrl::for($this->getRawOriginal('image_path') ?: $path);
        }
    }
}