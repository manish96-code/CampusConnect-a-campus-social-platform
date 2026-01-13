<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageKitService
{
    public function upload(UploadedFile $file, string $folder): string
    {
        $publicKey  = config('services.imagekit.public_key');
        $privateKey = config('services.imagekit.private_key');
        
        $payload = [
            'file'         => base64_encode(file_get_contents($file->getRealPath())),
            'fileName'     => uniqid() . '.' . $file->getClientOriginalExtension(),
            'useUniqueFileName' => 'true',
            'folder'       => $folder,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://upload.imagekit.io/api/v1/files/upload');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $privateKey . ':');
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("cURL Error: " . $error);
        }

        $result = json_decode($response);

        if (isset($result->error)) {
            throw new \Exception("ImageKit Error: " . ($result->error->message ?? 'Upload failed'));
        }

        return $result->url;
    }
}