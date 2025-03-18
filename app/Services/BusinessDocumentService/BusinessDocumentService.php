<?php

namespace App\Services\BusinessDocumentService;

use App\Facades\ImageFacade\ImageFacade;
use App\Models\BusinessDocument;

class BusinessDocumentService
{

    /**
     * Method store
     *
     * @param $data $data [explicite description]
     *
     * @return void
     */
    public function store($data)
    {

        $image = ImageFacade::store($data['image']);

        return BusinessDocument::create([
            'title' => $data['title'],
            'image_id' => $image['id'],
        ]);
    }

    /**
     * Method all
     *
     * @return void
     */
    public function all()
    {
        $defaultDocumentTitles = [
            'br_image',
            'license_image',
            'slbfe_front_image',
            'slbfe_back_image',
        ];

        $latest_documents = [];

        foreach ($defaultDocumentTitles as $title) {
            $document = BusinessDocument::with('image')->where('title', $title)->latest()->first();
            $latest_documents[$title] = $document && $document->image ? $document->image->path : null;
        }

        return $latest_documents;

    }
}
