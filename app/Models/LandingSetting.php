<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LandingSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getValue(string $key, string $default = ''): string
    {
        $all = self::allCached();

        return (string) ($all[$key] ?? $default);
    }

    public static function allCached(): array
    {
        return Cache::remember('landing_settings_all', 300, function () {
            return self::query()->pluck('value', 'key')->all();
        });
    }

    public static function forgetCache(): void
    {
        Cache::forget('landing_settings_all');
    }

    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            self::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
        self::forgetCache();
    }
}
