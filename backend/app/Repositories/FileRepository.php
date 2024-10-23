<?php

namespace App\Repositories;

use App\Services\Interfaces\FileStorageInterface;

class FileRepository {
    protected $storage;

    public function __construct(FileStorageInterface $storage) {
        $this->storage = $storage;
    }

    public function saveFile($file, $path) {
        // Store file using the storage service
        return $this->storage->uploadFile($file, $path);
    }

    public function getFileUrl($path) {
        return $this->storage->getFileUrl($path);
    }
}
