<?php

namespace App\Services;

use App\Repositories\ImageRepository;
use App\Services\Interfaces\ImageInterface;

class ImageService implements ImageInterface {

    private $imageRepository;

    public function __construct(ImageRepository $imageRepository) {
        $this->imageRepository = $imageRepository;
    }

    public function getImagesByFilters(array $filters = []) {

        if (auth()->user()->role === 'user') {
            $filters['user_id'] = auth()->user()->id;
        }
        return $this->imageRepository->getImagesByFilters($filters);
    }
    public function getMainImages() {
        $filters = [];
        if (auth()->user()->role === 'user') {
            $filters['user_id'] = auth()->user()->id;
        }
        return $this->imageRepository->getMainImages($filters);
    }

    public function getImagesVariants($id) {
        $filters = [];
        if (auth()->user()->role === 'user') {
            $filters['user_id'] = auth()->user()->id;
        }
        $filters['id'] = $id;

        return $this->imageRepository->getImagesByFilters($filters)->first();
    }

    public function store($file, $path, $data = []) {
        return $this->imageRepository->store($file, $path, $data);
    }
}
