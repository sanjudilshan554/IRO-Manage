<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

// use Illuminate\Database\Eloquent\Model;

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
        'phone_2',
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

    protected $casts = [
        'dispatch_countries' => 'array',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'logo');
    }
}
