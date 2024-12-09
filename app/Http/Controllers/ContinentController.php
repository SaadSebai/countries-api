<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContinentResource;
use App\Models\Continent;
use Illuminate\Http\Request;

class ContinentController extends Controller
{
    public function index()
    {
        $continents = Continent::all();

        return ContinentResource::collection($continents);
    }

    public function show(Continent $continent)
    {
        return new ContinentResource($continent);
    }
}
