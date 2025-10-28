<?php

namespace Database\Seeders;

use App\Models\Qualification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Qualification::create([
            'name' => 'worker',
            'daily_rate' => 3500,
        ]);

        Qualification::create([
            'name' => 'technician',
            'daily_rate' => 5000,
        ]);

        Qualification::create([
            'name' => 'engineer',
            'daily_rate' => 10000,
        ]);
    }
}
