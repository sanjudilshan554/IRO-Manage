<?php

namespace App\Http\Controllers;


use App\Facades\BusinessFacade\BusinessFacade;
use App\Facades\ImageFacade\ImageFacade;
use App\Http\Requests\BusinessRequests\CreateBusinessRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BusinessController extends Controller
{
    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        return Inertia::render('company/index');
    }

    /**
     * Method store
     *
     * @param CreateBusinessRequest $request [explicite description]
     *
     * @return void
     */
    public function store(CreateBusinessRequest $request)
    {
        $data = $request->all();
        return BusinessFacade::store($data);
    }

    /**
     * Method all
     *
     * @return void
     */
    public function all()
    {
        return BusinessFacade::all();
    }

    public function updateProfileLogo(Request $request)
    {
        return BusinessFacade::updateProfileLogo($request->all());
    }
}
