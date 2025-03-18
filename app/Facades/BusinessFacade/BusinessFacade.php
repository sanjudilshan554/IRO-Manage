<?php

namespace App\Facades\BusinessFacade;


use App\Services\BusinessService\BusinessService;
use Illuminate\Support\Facades\Facade;

class BusinessFacade extends Facade
{
    /**
     * Method getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return BusinessService::class;
    }
}
