<?php

namespace App\Repositories;

use App\DTO\UploadedFile;
use App\File;

class FileRepository
{
    /**
     * Create new File.
     *
     * @param string $url
     *
     * @return File
     */
    public function create(string $url): File
    {
        $file = new File();
        $file->fill([
            'status' => File::STATUS_QUEUED,
            'url'    => $url
        ])->save();

        return $file;
    }

    /**
     * File was successful downloaded.
     *
     * @param File         $file
     * @param UploadedFile $uploadedFile
     *
     * @return void
     */
    public function success(File $file, UploadedFile $uploadedFile)
    {
        $file->update([
            'real_name' => $uploadedFile->getName(),
            'mime_type' => $uploadedFile->getMimeType(),
            'size'      => $uploadedFile->getSize(),
            'ext'       => $uploadedFile->getExt(),
            'status'    => File::STATUS_SUCCESS
        ]);
    }

    /**
     * Set error status.
     *
     * @param File $file
     *
     * @return void
     */
    public function error(File $file)
    {
        $file->update([
            'status'    => File::STATUS_ERROR
        ]);
    }
}
