<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompanyController extends Controller
{
    public function index()
    {
        return Inertia::render('company/index');
    }

    public function store(Request $request)
    {
        return Company::create([
            'name' => $request->name,
        ]);
    }
}
