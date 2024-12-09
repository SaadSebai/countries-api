<?php

namespace Database\Seeders;

use App\Imports\CityImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('data/cities.xlsx');

        Excel::import(new CityImport($this->command), $filePath);
    }
}
