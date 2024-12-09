<?php

namespace App\Http\Controllers;

use App\Http\Requests\City\IndexCityRequest;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(IndexCityRequest $request)
    {
        $data = $request->validated();

        $cities = City::query()
                    ->filter($data['filters'] ?? [])
                    ->additionalData($data['with'] ?? [])
                    ->paginate($data['page_size'] ?? null);

        return CityResource::collection($cities);
    }

    public function show(City $city)
    {
        $city->load('country', 'continent');

        return new CityResource($city);
    }
}
