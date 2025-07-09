<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|unique:addresses,title',
            'recipient_name' => 'nullable',
            'phone_number' => 'nullable',
            'address_1' => 'nullable',
            'address_2' => 'nullable',
            'country' =>  'nullable',
            'province' => 'nullable',
            'regency' => 'nullable',
            'district' => 'nullable',
            'postal_code' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => [$errors]
        ], 400));
    }
}
