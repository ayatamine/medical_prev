<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('sanctum')->user() && auth('sanctum')->user()->tokenCan('patient:update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'full_name' => 'nullable|string|max:300',
                'birth_date' => 'nullable|date',
                'height' => 'nullable|numeric',
                'weight' => 'nullable|numeric',
                'age' => 'nullable|integer|between:1,110',
                'gender' => 'nullable|string|in:male,female',
                'chronic_diseases_id' => 'nullable|integer|exists:chronic_diseases,id',
                'family_history_id' => 'nullable|integer|exists:family_histories,id',
                'allergy_id' => 'nullable|integer|exists:allergies,id',
                'has_physical_activity' => 'boolean|in:0,1',
                'has_cancer_screening' => 'boolean|in:0,1',
                'has_depression_screening' => 'boolean|in:0,1',
                'other_problems' => 'nullable|json',
        ];
    }
}
