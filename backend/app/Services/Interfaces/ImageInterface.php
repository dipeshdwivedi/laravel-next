<?php

namespace App\Services\Interfaces;

interface ImageInterface {
    public function getImagesByFilters(array $filters);
    public function store($file, $path, $data= []);
}
