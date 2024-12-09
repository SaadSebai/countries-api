<?php

namespace Database\Seeders;

use App\Imports\CountryImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('data/countries.xlsx');

        Excel::import(new CountryImport(), $filePath);
    }
}
