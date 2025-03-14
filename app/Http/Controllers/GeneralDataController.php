<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;

class GeneralDataController extends Controller
{
    public function allCountries()
    {
        return response()->json(Country::all());
    }

    public function allCurrencies()
    {
        return response()->json(Currency::all());
    }
}
