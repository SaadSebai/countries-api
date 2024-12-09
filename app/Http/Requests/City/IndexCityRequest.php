<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class IndexCityRequest extends FormRequest
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
            'page_size'             => ['nullable', 'integer', 'min:5', 'max:100'],
            'with'                  => ['nullable', 'array'],
            'with.continent'        => ['nullable', 'bool'],
            'with.country'          => ['nullable', 'bool'],
            'filters'               => ['nullable', 'array'],
            'filters.name'          => ['nullable', 'string', 'min:1', 'max:255'],
            'filters.is_capital'    => ['nullable', 'bool'],
            'filters.continent_id'  => ['nullable', 'bail', 'exists:continents,id', 'min:1'],
            'filters.country_id'    => ['nullable', 'bail', 'exists:countries,id', 'min:1'],
        ];
    }
}
