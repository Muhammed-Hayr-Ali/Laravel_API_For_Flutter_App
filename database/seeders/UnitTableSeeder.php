<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;
use Faker\Factory as Faker;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = ['Pack', 'Kilogram', 'Liter', 'Package', 'Unit', 'Square Meter', 'Pair', 'Meter', 'Gram', 'Hour', 'Yard', 'Inch', 'Gallon'];
        $faker = Faker::create();

        foreach ($units as $unit) {
            Unit::create([
                'name' => $unit,
                'description' => $faker->text($maxNbChars = 10),
                'image' => $faker->imageUrl,
            ]);
        }
    }
}