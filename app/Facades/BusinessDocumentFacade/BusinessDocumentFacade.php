<?php

namespace App\Facades\BusinessDocumentFacade;

use App\Services\BusinessDocumentService\BusinessDocumentService;
use Illuminate\Support\Facades\Facade;

class BusinessDocumentFacade extends Facade
{
    /**
     * Method getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return BusinessDocumentService::class;
    }
}