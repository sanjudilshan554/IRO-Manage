<?php


namespace App\Facades\ImageFacade;

use App\Services\ImageService\ImageService;
use Illuminate\Support\Facades\Facade;

class ImageFacade extends Facade
{
    /**
     * Method getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return ImageService::class;
    }
}