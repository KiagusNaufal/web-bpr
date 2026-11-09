<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Models\Concerns\ResolvesMediaUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use ResolvesMediaUrl;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['status' => PublishStatus::class];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PublishStatus::Published->value);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->mediaUrl($this->photo_path);
    }
}
