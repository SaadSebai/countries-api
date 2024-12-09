<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Znck\Eloquent\Relations\BelongsToThrough;
use Znck\Eloquent\Traits\BelongsToThrough as BelongsToThroughTrait;

class City extends Model
{
    use BelongsToThroughTrait;

    protected $fillable = [
        'name',
        'is_capital',
        'lat',
        'lng',
        'country_id',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function continent(): BelongsToThrough
    {
        return $this->belongsToThrough(Continent::class, Country::class);
    }

    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        return $query
            // Name
            ->when(
                $filters['name'] ?? false,
                fn(Builder $query) => $query->where('name', 'like', '%' . $filters['name'] . '%')
            )
            // Is Capital
            ->when(
                isset($filters['is_capital']),
                fn(Builder $query) => $query->whereIsCapital($filters['is_capital'])
            )
            // Country Id
            ->when(
                $filters['country_id'] ?? false,
                fn (Builder $query) => $query->whereCountryId($filters['country_id'])
            )
            // Continent Id
            ->when(
                $filters['continent_id'] ?? false,
                fn (Builder $query) => $query->whereHas(
                    'continent',
                    fn(Builder $query) => $query->where('continents.id', $filters['continent_id'])
                ));
    }

    public function scopeAdditionalData(Builder $query, array $with = []): Builder
    {
        return $query
            ->when($with['continent'] ?? false, fn (Builder $query) => $query->with('continent'))
            ->when($with['country'] ?? false, fn (Builder $query) => $query->with('country'));
    }
}
