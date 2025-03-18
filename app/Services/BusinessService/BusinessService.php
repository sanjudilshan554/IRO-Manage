<?php

namespace App\Services\BusinessService;

use App\Models\Business;

class BusinessService
{
    public function store(array $data)
    {
        $existBusinessProfile = Business::first();

        $businessData = [
            'name' => $data['name'],
            'company_code' => $data['company_code'],
            'slbfe_reg_code' => $data['slbfe_reg_code'],
            'address' => $data['address'],
            'postal_code' => $data['postal_code'],
            'city' => $data['city'],
            'status' => $data['status'],
            'dispatch_countries' => $data['dispatch_countries'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'phone_2' => $data['phone_2'],
            'website' => $data['website'],
            'tax_id' => $data['tax_id'],
            'registration_number' => $data['registration_number'],
            'industry' => $data['industry'],
            'business_type' => $data['business_type'],
            'currency' => $data['currency'],
            'bank_account_details' => $data['bank_account_details'],
            'category' => $data['category'] ?? null,
            'logo' => $data['logo'],
            'notes' => $data['notes'],
            'created_by' => $data['created_by'],
            'updated_by' => $data['updated_by'],
        ];

        return Business::updateOrCreate(
            ['id' => $existBusinessProfile->id ?? null],
            $businessData
        );
    }

    public function all()
    {
        $businessProfile =  Business::first();
        return $businessProfile;
    }
}
