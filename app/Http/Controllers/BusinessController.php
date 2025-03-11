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
            'company_code' => $request->company_code,
            'slbfe_reg_code' => $request->slbfe_reg_code,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'status' => $request->status,
            'dispatch_countries' => $request->dispatch_countries,
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website,
            'tax_id' => $request->tax_id,
            'registration_number' => $request->registration_number,
            'industry' => $request->industry,
            'business_type' => $request->business_type,
            'currency' => $request->currency,
            'bank_account_details' => $request->bank_account_details,
            'category' => $request->category,
            'logo' => $request->logo,
            'notes' => $request->notes,
            'created_by' => $request->created_by,
            'updated_by' => $request->updated_by,
        ]);
    }
}
