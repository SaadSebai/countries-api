<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\Continent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $continent_id
 * @property Continent $continent
 * @property City $capitalCity
 */
class CountryResource extends JsonResource
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
            + $this->capitalCityData();
    }

    private function initialData(): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'code'          => $this->code,
            'continent_id'  => $this->continent_id,
        ];
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
     * @return array|array[]
     */
    public function capitalCityData(): array
    {
        return $this->relationLoaded('capitalCity')
            ? [
                'capital_city' => [
                    'id' => $this->capitalCity->id,
                    'name' => $this->capitalCity->name,
                ]
            ]
            : [];
    }
}
