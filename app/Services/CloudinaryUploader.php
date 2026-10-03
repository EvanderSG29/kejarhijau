<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryUploader
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        // CLOUDINARY_URL dibaca dari .env (lewat config agar tetap jalan saat config:cache di Render).
        $this->cloudinary = new Cloudinary(config('services.cloudinary.url'));
    }

    /**
     * Upload file ke Cloudinary dan kembalikan secure_url.
     */
    public function upload(UploadedFile $file, string $folder = 'kejarhijau'): string
    {
        $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => $folder,
        ]);

        return $result['secure_url'];
    }
}
