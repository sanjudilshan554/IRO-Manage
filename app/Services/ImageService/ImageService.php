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


    /**
     * Method store
     *
     * @param $image $image [explicite description]
     *
     * @return void
     */
    public function store($image)
    {
        if (isset($image)) {
            $path = $image->storePublicly('/public/images');
            $data['path'] = Storage::disk('s3')->url($path);
            return $this->image->create($data);

        }
    }
}
