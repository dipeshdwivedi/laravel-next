<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Jobs\GenerateImage;
use App\Services\ImageService;

class ImageController extends Controller {

    protected $imageServie;

    public function __construct(ImageService $imageServie) {
        $this->imageServie = $imageServie;
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $images = $this->imageServie->getMainImages();
        $images->load('user');
        return ImageResource::collection($images);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImageRequest $request) {
        $file = $request->file('image');
        $path = 'uploads';
        $data = [
          'user_id' => auth()->user()->id
        ];

        $fileRecord = $this->imageServie->store($file, $path, $data);

        // Dispatch the job to generate the image in the background
        GenerateImage::dispatch($fileRecord);

        return new ImageResource($fileRecord);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $image) {
        $image = $this->imageServie->getImagesVariants(decrypt($image));
        $image->load(['user', 'imageVariations']);
        return new ImageResource($image);
    }
}
