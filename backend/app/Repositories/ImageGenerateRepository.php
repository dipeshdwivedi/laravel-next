<?php

namespace App\Repositories;

use App\Services\Interfaces\ImageGenerationInterface;

class ImageGenerateRepository {
    protected $generator;

    public function __construct(ImageGenerationInterface $generator) {
        $this->generator = $generator;
    }

    public function generateImage($data) {
        // Store file using the generator service
        return $this->generator->generateImage($data);
    }
}
