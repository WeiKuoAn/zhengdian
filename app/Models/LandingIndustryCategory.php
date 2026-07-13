<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandingIndustryCategory extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'grid_columns',
        'seq',
        'status',
    ];

    public function brandClients(): HasMany
    {
        return $this->hasMany(LandingBrandClient::class, 'category_id');
    }

    public function activeBrandClients(): HasMany
    {
        return $this->brandClients()
            ->where('status', 'up')
            ->orderBy('seq')
            ->orderBy('id');
    }
}
