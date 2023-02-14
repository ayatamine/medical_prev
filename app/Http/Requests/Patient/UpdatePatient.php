<?php

namespace App\Http\Requests\Patient;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePatient extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->patient);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'full_name' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'string'],
            'thumbnail' => ['sometimes', 'string'],
            'phone_number' => ['sometimes', 'string'],
            'otp_verification_code' => ['nullable', 'string'],
            'gender' => ['sometimes', 'string'],
            'address' => ['nullable', 'string'],
            'other_problems' => ['nullable', 'string'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'otp_expire_at' => ['nullable', 'date'],
            'notification_status' => ['sometimes', 'boolean'],
            'has_physical_activity' => ['sometimes', 'boolean'],
            'has_cancer_screening' => ['sometimes', 'boolean'],
            'has_depression_screening' => ['sometimes', 'boolean'],
            'account_status' => ['sometimes', 'boolean'],
            'age' => ['nullable', 'integer'],
                    
            'family_history' => ['array', 'nullable'],
            'chronic_disease' => ['array', 'nullable'],
            'allergy' => ['array', 'nullable'],
            
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function sanitizedArray(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
    /**
    * Return modified (sanitized data) as a php object
    * @return  object
    */
    public function sanitizedObject(): object {
        $sanitized = $this->sanitizedArray();
        return json_decode(collect($sanitized));
    }
}
