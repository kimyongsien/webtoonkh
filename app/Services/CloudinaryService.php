<?php

namespace App\Services;

use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use RuntimeException;

class CloudinaryService
{
    public function __construct(
        private HttpFactory $http,
    ) {
    }

    public function uploadImage(UploadedFile $file, string $folder): array
    {
        $cloudName = (string) config('services.cloudinary.cloud_name');
        $apiKey = (string) config('services.cloudinary.api_key');
        $apiSecret = (string) config('services.cloudinary.api_secret');

        if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
            throw new RuntimeException('Cloudinary is not configured. Please set CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, and CLOUDINARY_API_SECRET.');
        }

        $response = $this->http
            ->withBasicAuth($apiKey, $apiSecret)
            ->asMultipart()
            ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
            ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'folder' => trim($folder, '/'),
            ])
            ->throw()
            ->json();

        return [
            'public_id' => Arr::get($response, 'public_id'),
            'secure_url' => Arr::get($response, 'secure_url'),
        ];
    }

    public function destroyImage(?string $publicId): void
    {
        if (blank($publicId)) {
            return;
        }

        $cloudName = (string) config('services.cloudinary.cloud_name');
        $apiKey = (string) config('services.cloudinary.api_key');
        $apiSecret = (string) config('services.cloudinary.api_secret');

        if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
            return;
        }

        $this->http
            ->withBasicAuth($apiKey, $apiSecret)
            ->asForm()
            ->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/destroy", [
                'public_id' => $publicId,
                'invalidate' => 'true',
            ])
            ->throw();
    }
}
