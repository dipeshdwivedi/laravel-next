<?php

namespace App\Repositories;

use App\Models\Image;
use App\Services\Interfaces\FileStorageInterface;

class ImageRepository {
    protected $image;
    protected $fileStorage;

    public function __construct(Image $image, FileStorageInterface $fileStorage) {
        $this->image = $image;
        $this->fileStorage = $fileStorage;
    }

    public function store($file, $path, $data = []) {
        $storedPath = $this->fileStorage->uploadFile($file, $path);
        // Store file metadata in the database
        $_data = [
            'name' => $file->getClientOriginalName(),
            'path' => $storedPath,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType()
        ];
        if (isset($data['user_id'])) {
            $_data['user_id'] = $data['user_id'];
        }
        if (isset($data['image_id'])) {
            $_data['image_id'] = $data['image_id'];
        }

        return $this->image->create($_data);
    }

    public function getImagesByFilters($filters) {
        $image = $this->image->query();

        if (isset($filters['user_id'])) {
            $image->where('user_id', $filters['user_id']);
        }

        if (isset($filters['id'])) {
            $image->where('id', $filters['id']);
        }

        return $image->latest()->get();
    }

    public function getMainImages($filters) {
        $image = $this->image->query();

        if (isset($filters['user_id'])) {
            $image->where('user_id', $filters['user_id']);
        }
        $image->whereNull('image_id');

        return $image->latest()->get();
    }
}
