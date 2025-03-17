<?php

namespace App\Http\Controllers;

use App\Facades\ImageFacade\ImageFacade;
use App\Models\BusinessDocument;
use Illuminate\Http\Request;

class BusinessDocumentController extends Controller
{
    public function store(Request $request)
    {

        // return $request->file('image');
        $image = ImageFacade::store($request->file('image'));

        return $image;

        BusinessDocument::create([
            'type' => $request->type,
            'image_id' => $image->id,
        ]);
    }
}
