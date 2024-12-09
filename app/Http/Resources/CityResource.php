<?php

namespace App\Http\Resources;

use App\Models\Continent;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $name
 * @property bool $is_capital
 * @property float $lat
 * @property float $lng
 * @property int $country_id
 * @property Continent $continent
 * @property Country $country
 */
class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->initialData()
            + $this->continentData()
            + $this->countryData();
    }

    /**
     * @return array|array[]
     */
    public function continentData(): array
    {
        return $this->relationLoaded('continent')
            ? [
                'continent' => [
                    'id' => $this->continent->id,
                    'name' => $this->continent->name,
                ]
            ]
            : [];
    }

    /**
     * @return array[]
     */
    public function initialData(): array
    {
        return [
            'name'          => $this->name,
            'is_capital'    => $this->is_capital,
            'lat'           => $this->lat,
            'lng'           => $this->lng,
            'country_id'    => $this->country_id,
        ];
    }

    /**
     * @return array|array[]
     */
    public function countryData(): array
    {
        return $this->relationLoaded('continent')
            ? [
                'country' => [
                    'id' => $this->country->id,
                    'name' => $this->country->name,
                ]
            ]
            : [];
    }
}
