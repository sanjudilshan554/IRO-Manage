<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BusinessController extends Controller
{
    public function index()
    {
        return Inertia::render('company/index');
    }

    public function store(Request $request)
    {
        return Business::create([
            'name' => $request->name,
        ]);
    }
}
