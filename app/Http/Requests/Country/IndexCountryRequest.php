<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $page_size
 * @property mixed $filters
 */
class IndexCountryRequest extends FormRequest
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
            'page_size'                 => ['nullable', 'integer', 'min:5', 'max:100'],
            'with'                      => ['nullable', 'array'],
            'with.continent'            => ['nullable', 'bool'],
            'with.capital_city'         => ['nullable', 'bool'],
            'filters'                   => ['nullable', 'array'],
            'filters.name'              => ['nullable', 'string', 'min:1', 'max:255'],
            'filters.code'              => ['nullable', 'string', 'min:3', 'max:3'],
            'filters.continent_id'      => ['nullable', 'bail', 'exists:continents,id', 'min:1'],
        ];
    }
}
