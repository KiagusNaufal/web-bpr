<?php

namespace App\Models;

use App\Enums\ProductType;
use App\Enums\PublishStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Concerns\ResolvesMediaUrl;

class Product extends Model
{
    use ResolvesMediaUrl;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'type' => ProductType::class,
            'status' => PublishStatus::class,
            'benefits' => 'array',
            'requirements' => 'array',
            'is_featured' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PublishStatus::Published->value);
    }

    public function scopeOfType(Builder $query, ProductType $type): Builder
    {
        return $query->where('type', $type->value);
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->mediaUrl($this->image_path);
    }
}

