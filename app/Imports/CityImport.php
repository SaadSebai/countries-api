<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Continent;
use App\Models\Country;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Console\Command;

class CityImport implements ToCollection, WithHeadingRow
{
    protected Collection $countries;
    protected Collection $continents;
    protected ConsoleOutput $output;

    public function __construct(protected Command $command)
    {
        $this->countries = Country::all()
            ->pluck('id', 'code');

        $this->continents = Continent::all()
            ->pluck('id', 'name');


        $this->output = new ConsoleOutput();
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection): void
    {
        $this->insertData(
            $this->prepareData($collection)
        );
    }

    private function prepareData(Collection $collection): Collection
    {
        $this->command->info('Data preparation!');

        $progressBar = new ProgressBar($this->output, $collection->count());
        $progressBar->start();

        $data = $collection->map(function($row) use ($progressBar) {
            if (!isset($this->countries[$row['iso3']]))
            {
                $this->addMissingCountry($row);
            }

            $progressBar->advance();

            return [
                'name'          => $row['city'],
                'is_capital'    => $row['capital'] == 'primary',
                'lat'           => $row['lat'],
                'lng'           => $row['lng'],
                'country_id'    => $this->countries[$row['iso3']],
            ];
        });

        $progressBar->finish();

        $this->command->newLine();

        $this->command->info('Data is prepared');

        return $data;
    }

    private function insertData(Collection $data): void
    {
        $this->command->info('Data saving!');
        $progressBar = new ProgressBar($this->output, $data->count());
        $progressBar->start();

        foreach ($data->chunk(10) as $chunk)
        {
            City::insert($chunk->toArray());

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->newLine();

        $this->command->info('Data is saved!');
    }

    private function findContinent(string $continent)
    {
        $continent = match ($continent)
        {
            'Caribbean' => 'South America',
            'Oceania' => 'Australia',
            default => $continent,
        };

        return $this->continents[$continent];
    }

    private function addMissingCountry(Collection $row): void
    {
        $country = Country::create([
            'name' => $row['country'],
            'code' => $row['iso3'],
            'continent_id' => $this->findContinent($row['continent']),
        ]);

        $this->countries = $this->countries->put($country->code, $country->id);
    }
}
