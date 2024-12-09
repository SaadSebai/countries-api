<?php

namespace App\Http\Controllers;

use App\Http\Requests\Country\IndexCountryRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(IndexCountryRequest $request)
    {
        $data = $request->validated();

        $countries = Country::query()
                        ->filter($data['filters'] ?? [])
                        ->additionalData($data['with'] ?? [])
                        ->paginate($data['page_size'] ?? null);

        return CountryResource::collection($countries);
    }

    public function show(Country $country)
    {
        $country->load('continent', 'capitalCity');

        return new CountryResource($country);
    }
}
