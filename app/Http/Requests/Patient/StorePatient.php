<?php
namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\Patient;
class StorePatient extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create',Patient::class);
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
            'thumbnail' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'otp_verification_code' => ['nullable', 'string'],
            'gender' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'other_problems' => ['nullable', 'string'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'otp_expire_at' => ['nullable', 'date'],
            'notification_status' => ['required', 'boolean'],
            'has_physical_activity' => ['required', 'boolean'],
            'has_cancer_screening' => ['required', 'boolean'],
            'has_depression_screening' => ['required', 'boolean'],
            'account_status' => ['required', 'boolean'],
            'age' => ['nullable', 'integer'],
                    
            'chronic_disease' => ['array', 'nullable'],
            'allergy' => ['array', 'nullable'],
            'family_history' => ['array', 'nullable'],
                
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
