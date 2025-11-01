<?php

namespace Database\Seeders;

use App\Models\Qualification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $qualifications = [
            [
                'name' => 'worker',
                'daily_rate' => 4000,
            ],
            [
                'name' => 'technician',
                'daily_rate' => 7000,
            ],
            [
                'name' => 'engineer',
                'daily_rate' => 10000,
            ],
        ];

        foreach ($qualifications as $qualification) {
            $existQualification = DB::table('qualifications')->where('name', $qualification['name'])->exists();

            if (!$existQualification) {
                Qualification::create($qualification);
            }
        }
    }
}
