<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id'            => encrypt($this->id),
            'name'          => $this->name,
            'size'          => $this->size,
            'mime_type'     => $this->mime_type,
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'),
            'url'           => $this->getFileUrl(),
            'user'          => new UserResource($this->whenLoaded('user')),
            'variations'    => ImageResource::collection($this->whenLoaded('imageVariations')),
        ];
    }
    /**
     * Generate the file URL based on the storage mechanism.
     */
    protected function getFileUrl() {
        // Use the file storage service (Local or S3) to get the correct URL.
        return resolve(\App\Services\Interfaces\FileStorageInterface::class)->getFileUrl($this->path);
    }
}
