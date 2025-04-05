<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'manufacturing_cost' => 'sometimes|required|numeric|min:0',

            'prices' => 'nullable|array',
            'prices.*.price' => 'required_with:prices|numeric|min:0',
            'prices.*.tax_cost' => 'required_with:prices|numeric|min:0',
            'prices.*.currency_id' => 'required_with:prices|exists:currencies,id',
        ];
    }

}
