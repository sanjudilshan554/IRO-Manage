<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessDocument extends Model
{
    protected $fillable = ['title', 'image_id'];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

}
