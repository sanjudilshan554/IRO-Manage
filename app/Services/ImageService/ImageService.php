<?php


namespace App\Services\ImageService;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    protected $image;

    public function __construct()
    {
        $this->image = new Image();
    }

    public function store($image)
    {
        if (isset($image)) {
             $path = $image->store('images', 's3');
             $url = Storage::disk('s3')->url($path);
             return $this->image->create(['path' => $url]);
        }
    }
}