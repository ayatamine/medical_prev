<?php

namespace Database\Seeders;

use App\Models\Scale;
use App\Models\PatientScale;
use App\Models\ScaleQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PatientScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Scale::factory(2)
                    ->hasScaleQuestion(3)
                    ->create();
        return PatientScale::factory(2)
                        ->create();
    }
}
