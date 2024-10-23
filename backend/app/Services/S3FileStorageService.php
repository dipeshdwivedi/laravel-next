<?php

namespace App\Services;

use App\Services\Interfaces\FileStorageInterface;
use Illuminate\Support\Facades\Storage;

class S3FileStorageService implements FileStorageInterface {

    public function uploadFile($file, $path): string {
        return Storage::disk('s3')->putFile($path, $file);
    }


    public function getFileUrl($path): string {
        $expires = now()->addMinutes(5); // Set the expiration time

        return Storage::disk('s3')->temporaryUrl($path, $expires);
    }
}
