<?php

namespace Database\Factories;

use App\Models\Scale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScaleQuestion>
 */
class ScaleQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'question'=>$this->faker->title(),
            'question_ar'=>'هنا مثال لعنوان',
            'scale_id'  =>  function () {
                return Scale::first()?->id || Scale::factory()->create()->id;
            },
        ];
    }
}
