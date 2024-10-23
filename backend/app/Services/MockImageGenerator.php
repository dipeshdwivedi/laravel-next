<?php

namespace App\Services;

use App\Services\Interfaces\ImageGenerationInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MockImageGenerator implements Interfaces\ImageGenerationInterface {
    protected $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function generateImage(array $data) {
        try {
            $response = $this->client->post('https://67163eac33bc2bfe40bd101c.mockapi.io/ImageVariant', [
                'json' => $data,
            ]); // Send a request to the mock API

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Mock image generation failed: ' . $e->getMessage());
            return null; // Handle as appropriate
        }
    }
}
