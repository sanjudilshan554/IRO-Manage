<?php

namespace App\Http\Controllers;

use App\Facades\BusinessFacade;
use App\Http\Requests\BusinessRequests\CreateBusinessRequest;
use App\Models\Business;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BusinessController extends Controller
{
    public function index()
    {
        return Inertia::render('company/index');
    }

    public function store(CreateBusinessRequest $request)
    {
        $data = $request->all();
        
        if (isset($data['dispatch_countries']) && is_array($data['dispatch_countries'])) {
            $data['dispatch_countries'] = json_encode($data['dispatch_countries']);
        }

        BusinessFacade::store($data);
    }
}
