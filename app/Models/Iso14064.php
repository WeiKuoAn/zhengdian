<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iso14064 extends Model
{
    use HasFactory;

    protected $table = "iso14064";

    protected $fillable = [
        'name','scope_id'
    ];

    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }
}
