<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'manufacturing_cost' => 'required|numeric|min:0',

            'prices' => 'nullable|array',
            'prices.*.price' => 'required_with:prices|numeric|min:0',
            'prices.*.tax_cost' => 'required_with:prices|numeric|min:0',
            'prices.*.currency_id' => 'required_with:prices|exists:currencies,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Errores de validación detectados',
            'errors' => $validator->errors(),
        ], 422));
    }
}
