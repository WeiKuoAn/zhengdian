<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GhgProtocol extends Model
{
    use HasFactory;
    protected $table = 'ghg_protocol';

    protected $fillable = [
        'iso14064_id',
        'name',
        // 其他可填充的字段
    ];
    /**
     * Get the iso14064 that owns the ghg_protocol.
     */
    public function iso14064()
    {
        return $this->belongsTo(Iso14064::class);
    }
}
