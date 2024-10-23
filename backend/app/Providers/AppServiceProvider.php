<?php

namespace App\Providers;

use App\Services\ImageService;
use App\Services\Interfaces\FileStorageInterface;
use App\Services\Interfaces\ImageGenerationInterface;
use App\Services\Interfaces\ImageInterface;
use App\Services\LocalFileStorageService;
use App\Services\MockImageGenerator;
use App\Services\S3FileStorageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        $this->app->bind(FileStorageInterface::class, S3FileStorageService::class);
//        $this->app->bind(FileStorageInterface::class, LocalFileStorageService::class);

// model
        $this->app->bind(ImageInterface::class, ImageService::class);

// image generated
        $this->app->bind(ImageGenerationInterface::class, MockImageGenerator::class);
    }
}
