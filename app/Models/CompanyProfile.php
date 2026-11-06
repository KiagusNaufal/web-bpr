<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\ResolvesMediaUrl;

class CompanyProfile extends Model
{
    use ResolvesMediaUrl;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'missions' => 'array',
            'values' => 'array',
        ];
    }

    /** Profil bersifat tunggal (satu baris). */
    public static function current(): self
    {
        return static::query()->first() ?? new static(['name' => config('app.name')]);
    }

    public function getWhatsappUrlAttribute(): ?string
    {
        return $this->whatsapp ? 'https://wa.me/'.preg_replace('/\D/', '', $this->whatsapp) : null;
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->mediaUrl($this->logo_path);
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->mediaUrl($this->hero_image_path);
    }
}

