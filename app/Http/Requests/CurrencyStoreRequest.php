<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CurrencyStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'symbol' => 'required|string',
            'exchange_rate' => 'required|numeric|min:0',
        ];
    }

    /**
     * Personaliza la respuesta de error cuando la validación falla.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Errores de validación detectados',
            'errors' => $validator->errors(),
        ], 422));
    }
}
