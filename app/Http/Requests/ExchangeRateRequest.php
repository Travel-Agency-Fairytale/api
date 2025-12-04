<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'currencyCodeA' => ['required', 'numeric', 'exists:currencies,numeric_code'],
            'currencyCodeB' => ['required', 'numeric', 'exists:currencies,numeric_code'],
            'date' => ['required', 'date'],
            'rateBuy' => ['nullable', 'numeric'],
            'rateSell' => ['nullable', 'numeric'],
            'rateCross' => ['nullable', 'numeric'],
        ];
    }
}
