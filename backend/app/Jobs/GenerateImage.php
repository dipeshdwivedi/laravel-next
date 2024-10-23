<?php

namespace App\Jobs;

namespace App\Jobs;

use App\Services\ImageService;
use App\Services\MockImageGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateImage implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $imageData;

    public function __construct($imageData) {
        $this->imageData = $imageData;
    }

    public function handle() {
        $imageGenerator = app(MockImageGenerator::class);
        $image = app(ImageService::class);
        $result = $imageGenerator->generateImage($this->imageData->toArray());
        if(!$result) return;

        $data = [
            'user_id' => $this->imageData->user_id,
            'image_id' => $this->imageData->id,
        ];

        if(isset($result[0])) {
            $file = @file_get_contents($result[0]);
            $tempFilePath = tempnam(sys_get_temp_dir(), 'img');
            file_put_contents($tempFilePath, $file);

            // Create an UploadedFile instance
            $uploadedFile = new UploadedFile(
                $tempFilePath,
                basename($result[0]), // Original name
                null, // MIME type can be null here
                null,
                false // Test mode
            );

            // Store the file
            $path = 'uploads';
            $image->store($uploadedFile, $path, $data);
        }

        if(isset($result[1])) {
            $file = @file_get_contents($result[0]);
            $tempFilePath = tempnam(sys_get_temp_dir(), 'img');
            file_put_contents($tempFilePath, $file);

            // Create an UploadedFile instance
            $uploadedFile = new UploadedFile(
                $tempFilePath,
                basename($result[0]), // Original name
                null, // MIME type can be null here
                null,
                false // Test mode
            );

            // Store the file
            $path = 'uploads';
            $image->store($uploadedFile, $path, $data);
        }

    }
}
