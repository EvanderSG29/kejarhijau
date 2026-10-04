<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryUploader
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        // CLOUDINARY_URL dibaca dari config services.cloudinary.url (mengarah ke .env)
        $this->cloudinary = new Cloudinary(config('services.cloudinary.url'));
    }

    /**
     * Upload file (UploadedFile atau data URI / Base64 string) ke Cloudinary dan kembalikan secure_url.
     */
    public function upload(UploadedFile|string $file, string $folder = 'kejarhijau'): string
    {
        $source = $file instanceof UploadedFile ? $file->getRealPath() : $file;

        $result = $this->cloudinary->uploadApi()->upload($source, [
            'folder' => $folder,
        ]);

        return $result['secure_url'];
    }
}
