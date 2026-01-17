<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Karachi', 'code' => 'KHI', 'state' => 'Sindh'],
            ['name' => 'Lahore', 'code' => 'LHR', 'state' => 'Punjab'],
            ['name' => 'Islamabad', 'code' => 'ISB', 'state' => 'ICT'],
            ['name' => 'Rawalpindi', 'code' => 'RWP', 'state' => 'Punjab'],
            ['name' => 'Faisalabad', 'code' => 'FSD', 'state' => 'Punjab'],
            ['name' => 'Multan', 'code' => 'MUL', 'state' => 'Punjab'],
            ['name' => 'Peshawar', 'code' => 'PSH', 'state' => 'KPK'],
            ['name' => 'Quetta', 'code' => 'QTA', 'state' => 'Balochistan'],
            ['name' => 'Hyderabad', 'code' => 'HYD', 'state' => 'Sindh'],
            ['name' => 'Gujranwala', 'code' => 'GUJ', 'state' => 'Punjab'],
            ['name' => 'Sialkot', 'code' => 'SKT', 'state' => 'Punjab'],
            ['name' => 'Sargodha', 'code' => 'SRG', 'state' => 'Punjab'],
            ['name' => 'Bahawalpur', 'code' => 'BWP', 'state' => 'Punjab'],
            ['name' => 'Sukkur', 'code' => 'SKR', 'state' => 'Sindh'],
            ['name' => 'Larkana', 'code' => 'LRK', 'state' => 'Sindh'],
            ['name' => 'Sheikhupura', 'code' => 'SKP', 'state' => 'Punjab'],
            ['name' => 'Rahim Yar Khan', 'code' => 'RYK', 'state' => 'Punjab'],
            ['name' => 'Gujrat', 'code' => 'GJT', 'state' => 'Punjab'],
            ['name' => 'Kasur', 'code' => 'KSR', 'state' => 'Punjab'],
            ['name' => 'Mardan', 'code' => 'MRD', 'state' => 'KPK'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
