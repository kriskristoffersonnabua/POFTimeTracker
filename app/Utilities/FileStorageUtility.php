<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Storage;

class FileStorageUtility
{

    /**
     * Upload or get an existing file from S3
     *
     * @param file   $file      | File request
     *
     * @return Array
     */
    public function uploadOrGetFileFromS3($file_path, $content)
    {
        if (!Storage::disk('s3')->exists($file_path)) {
            return Storage::disk('s3')->put($file_path, $content, 'public');
        }
        return Storage::disk('s3')->get($file_path);
    }

    /**
     * Deletes a file from S3
     *
     * @param String $file
     *
     * @return Array
     */
    public function deleteFromS3($file_path)
    {
        return Storage::disk('s3')->delete($file_path);
    }

    /**
     * Updates a file from S3
     *
     * @param String $file
     *
     * @return Array
     */
    public function updateFileFromS3($file_path, $content)
    {
        return Storage::disk('s3')->put($file_path, $content);
    }
}
