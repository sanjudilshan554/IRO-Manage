<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'path',
    ];

    public function businessDocument()
    {
        return $this->hasOne(BusinessDocument::class);
    }

    public function business()
    {
        return $this->hasOne(Business::class);
    }
}


