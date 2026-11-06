<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\ResolvesMediaUrl;

class Media extends Model
{
    use ResolvesMediaUrl;

    protected $table = 'media';

    protected $guarded = ['id'];

    public function getUrlAttribute(): string
    {
        return $this->mediaUrl($this->path);
    }
}

