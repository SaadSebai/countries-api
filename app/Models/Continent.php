<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Continent extends Model
{
    protected $fillable = [
        'name',
        'size',
    ];

    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }

    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        return $query
            ->where('name', 'like', '%' . $filters['name'] . '%');
    }
}
