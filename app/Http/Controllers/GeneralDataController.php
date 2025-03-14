<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class GeneralDataController extends Controller
{
    public function allCountries()
    {
        return response()->json(Country::all());
    }
}
