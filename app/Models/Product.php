<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderItem;

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
        if (!$this->image_path) {
            return null;
        }

        $url = Storage::url($this->image_path);

        // Ensure absolute URL for non-S3/public disks
        if (is_string($url) && !str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            return url($url);
        }

        return $url;
    }
}
