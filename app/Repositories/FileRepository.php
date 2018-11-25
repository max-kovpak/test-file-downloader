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
            'status' => File::STATUS_PENDING,
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
    public function complete(File $file, UploadedFile $uploadedFile)
    {
        $file->update([
            'real_name' => $uploadedFile->getName(),
            'mime_type' => $uploadedFile->getMimeType(),
            'size'      => $uploadedFile->getSize(),
            'ext'       => $uploadedFile->getExt(),
            'status'    => File::STATUS_COMPLETE,
            'path'      => $uploadedFile->getPath(),
        ]);
    }

    /**
     * Update file status.
     *
     * @param File   $file
     * @param string $status File::STATUS_*
     *
     * @return void
     */
    public function updateStatus(File $file, string $status)
    {
        $file->update([
            'status'    => $status
        ]);
    }
}
