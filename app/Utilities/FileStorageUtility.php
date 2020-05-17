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
    public function uploadOrGetFileFromS3($file)
    {
        if (!Storage::disk('s3')->exists($file)) {
            return Storage::disk('s3')->put($file);
        }
        return Storage::disk('s3')->get($file);
    }

    /**
     * Deletes a file from S3
     *
     * @param String $file
     *
     * @return Array
     */
    public function deleteFromS3($file)
    {
        return Storage::disk('s3')->delete($file);
    }

    /**
     * Updates a file from S3
     *
     * @param String $file
     *
     * @return Array
     */
    public function updateFileFromS3($file)
    {
        return Storage::disk('s3')->put($file);
    }
}
