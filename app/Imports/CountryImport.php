<?php

namespace App\Imports;

use App\Models\Continent;
use App\Models\Country;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CountryImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection): void
    {
        $continents = Continent::all();

        $data = $collection->map(
                fn($row) => [
                    'name'          => $row['name'],
                    'code'          => $row['code'],
                    'continent_id'  => $continents->where('name', $row['continent'])->first()->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]
            );

        Country::insert($data->toArray());
    }
}
