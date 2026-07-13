<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingBrandClient extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'logo_path',
        'seq',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(LandingIndustryCategory::class, 'category_id');
    }

    public function logoUrl(): ?string
    {
        if (empty($this->logo_path)) {
            return null;
        }

        return asset('storage/'.$this->logo_path);
    }
}
