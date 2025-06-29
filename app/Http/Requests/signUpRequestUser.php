<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class signUpRequestUser extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'nullable',
            'username' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'birth_of_date' => 'nullable|date',
            'phone_number' => 'nullable',
            'role' => 'required|in:user,admin'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'nama depan wajib diisi!',
            'username.required' => 'username wajib diisi!',
            'username.max' => 'username terlalu panjang!',
            'email.required' => 'email wajib diisi!',
            'email.email' => 'format penulisan email salah!',
            'email.unique' => 'email sudah digunakan!',
            'birth_of_date.date' => 'format penulisan waktu salah!',
            'role.required' => 'role wajib diisi!',
            'role.in' => 'role harus berisi user atau admin!',
            'password.required' => 'password wajib diisi!'
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
