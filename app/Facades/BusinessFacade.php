<?php

namespace App\Facades;

use App\Services\BusinessService;
use Illuminate\Support\Facades\Facade;

class BusinessFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BusinessService::class;
    }
}
