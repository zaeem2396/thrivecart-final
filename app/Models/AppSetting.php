<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    public function scopeWhereKey(Builder $query, string $key): Builder
    {
        return $query->where('key', $key);
    }
}
