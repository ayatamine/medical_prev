<?php

namespace Database\Factories;

use App\Models\Scale;
use App\Models\Patient;
use App\Models\ScaleQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientScale>
 */
class PatientScaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $answers = ['not at all','sometimes','always'];
        $questions = ScaleQuestion::pluck('id');

        $quest_answer_collection=array();
        if(count($questions)){
            foreach ($questions as $q) {
                $quest_answer_collection[$q] = $answers[array_rand($answers)];
            }
        }
        return [
            'patient_id' => function () {
                return Patient::firstOrCreate(['phone_number'=>'+213667849526'])->id;
            },
            'scale_id' => function () {
                return Scale::factory()->create()->id;
            },
            'scale_questions_answers' => json_encode($quest_answer_collection)
        ];
    }
}
