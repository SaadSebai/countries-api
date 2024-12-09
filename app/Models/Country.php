<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'continent_id',
    ];

    public function continent(): BelongsTo
    {
        return $this->belongsTo(Continent::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function capitalCity(): HasOne
    {
        return $this->hasOne(City::class)->where('is_capital', true);
    }

    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        return $query
            // Name
            ->when(
                $filters['name'] ?? false,
                fn (Builder $query) => $query->where('name', 'like', '%' . $filters['name'] . '%')
            )
            // Code
            ->when(
                $filters['code'] ?? false,
                fn (Builder $query) => $query->where('code', 'like', '%' . $filters['code'] . '%')
            )
            // Continent Id
            ->when(
                $filters['continent_id'] ?? false,
                fn (Builder $query) => $query->whereContinentId($filters['continent_id'])
            );
    }

    public function scopeAdditionalData(Builder $query, array $with = []): Builder
    {
        return $query
            ->when($with['continent'] ?? false, fn (Builder $query) => $query->with('continent'))
            ->when($with['capital_city'] ?? false, fn (Builder $query) => $query->with('capitalCity'));
    }
}
