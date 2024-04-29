<?php

namespace App\Service;

use Cloudinary\Cloudinary;
use GuzzleHttp\Client;

class UploadImg
{
    private $cloudinary;
    private $client; 

    public function __construct(Cloudinary $cloudinary )
    {
        $this->cloudinary = $cloudinary; 
      
    }

    public function upload($file)
    {
       
        $uploadResult = $this->cloudinary->uploadApi()->upload($file);
        
        return $uploadResult['secure_url'];
    }
    public function uploadMultiple($files, $separator = ';')
    {
        $urls = [];

        foreach ($files as $file) {
            $filePath = $file->getRealPath();
            $urls[] = $this->upload($filePath);
        }

        return implode($separator, $urls);
    }
}
