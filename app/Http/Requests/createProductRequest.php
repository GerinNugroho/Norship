<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class createProductRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'description' => 'nullable',
            'sku' => 'required',
            'price' => 'required|numeric',
            'quatity' => 'requierd|integer|min:1',
            'image_url' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Nama wajib diisi!',
            'category_id.required' => 'Category wajib diisi!',
            'category_id.exists' => 'Category tidak ada!',
            'sku.required' => 'SKU wajib diisi!',
            'price.required' => 'Harga wajib diisi!',
            'price.numeric' => 'Harga harus berupa angka!',
            'quantity.required' => 'Stok product wajib diisi!',
            'quantity.integer' => 'Stok harus berupa angka!',
            'quantity.min' => 'Setidak stok lebih dari 0!'
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
