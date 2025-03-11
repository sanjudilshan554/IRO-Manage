<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'name',
        'company_code',
        'slbfe_reg_code',
        'address',
        'postal_code',
        'city',
        'dispatch_countries',
        'email',
        'phone',
        'website',
        'tax_id',
        'registration_number',
        'industry',
        'business_type',
        'currency',
        'bank_account_details',
        'status',
        'category',
        'logo',
        'notes',
        'created_by',
        'updated_by',
    ];



}
