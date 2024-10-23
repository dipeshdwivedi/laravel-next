<?php

namespace App\Services;

use App\Services\Interfaces\FileStorageInterface;
use Illuminate\Support\Facades\Storage;

class LocalFileStorageService implements FileStorageInterface {

    public function uploadFile($file, $path): string {
        return Storage::putFile($path, $file);
    }

    public function getFileUrl($path): string {
        return Storage::url($path);
    }
}
