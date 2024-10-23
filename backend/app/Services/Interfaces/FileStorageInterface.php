<?php

namespace App\Services\Interfaces;

interface FileStorageInterface {
    public function uploadFile($file, $path): string;
    public function getFileUrl($path): string;
}
