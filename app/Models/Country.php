<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
// use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable=[
        'name',
    ];
}
