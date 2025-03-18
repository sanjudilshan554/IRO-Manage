<?php

namespace App\Http\Controllers;

use App\Facades\BusinessDocumentFacade\BusinessDocumentFacade;
use Illuminate\Http\Request;

class BusinessDocumentController extends Controller
{
    /**
     * Method store
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function store(Request $request)
    {
        return BusinessDocumentFacade::store($request->all());
    }

    /**
     * Method all
     *
     * @return void
     */
    public function all()
    {
        return BusinessDocumentFacade::all();
    }
}
