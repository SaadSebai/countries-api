<?php

namespace Database\Seeders;

use App\Models\Continent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContinentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamps = ['created_at' => now(), 'updated_at' => now()];

        Continent::insert([
            ['name' => 'Asia', 'size' => 31033131, ...$timestamps],
            ['name' => 'Africa', 'size' => 29648481, ...$timestamps],
            ['name' => 'Europe', 'size' => 22134710, ...$timestamps],
            ['name' => 'North America', 'size' => 21330000, ...$timestamps],
            ['name' => 'South America', 'size' => 17461112, ...$timestamps],
            ['name' => 'Australia', 'size' => 46502478, ...$timestamps],
            ['name' => 'Antarctica', 'size' => 13720000, ...$timestamps],
        ]);
    }
}
