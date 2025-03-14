<?php

namespace App\Services;

use App\Models\Business;

class BusinessService
{
    public function store(array $data)
    {

        $existBusinessProfile = Business::first();

        $businessData = [
            'name' => $data['name'] ?? null,
            'company_code' => $data['company_code'] ?? null,
            'slbfe_reg_code' => $data['slbfe_reg_code'] ?? null,
            'address' => $data['address'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'city' => $data['city'] ?? null,
            'status' => $data['status'] ?? null,
            'dispatch_countries' => $data['dispatch_countries'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'website' => $data['website'] ?? null,
            'tax_id' => $data['tax_id'] ?? null,
            'registration_number' => $data['registration_number'] ?? null,
            'industry' => $data['industry'] ?? null,
            'business_type' => $data['business_type'] ?? null,
            'currency' => $data['currency'] ?? null,
            'bank_account_details' => $data['bank_account_details'] ?? null,
            'category' => $data['category'] ?? null,
            'logo' => $data['logo'] ?? null,
            'notes' => $data['notes'] ?? null,
            'created_by' => $data['created_by'] ?? null,
            'updated_by' => $data['updated_by'] ?? null,
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
