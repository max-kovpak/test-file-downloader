<?php

namespace App\Interfaces;

use App\Exceptions\FileNotAvailableException;
use App\DTO\UploadedFile;

/**
 * Interface FileDownloaderInterface
 *
 * @package App\Interfaces
 */
interface FileDownloaderInterface
{
    /**
     * FileDownloader constructor.
     *
     * @param FilesManagerInterface $fm
     */
    public function __construct(FilesManagerInterface $fm);

    /**
     * Download file.
     *
     * @param string  $url
     * @param integer $timeout
     *
     * @throws FileNotAvailableException
     */
    public function download(string $url, int $timeout): UploadedFile;

    /**
     * Check that file is available and can be downloaded.
     *
     * @param string $url
     *
     * @return bool
     */
    public function isDownloadable(string $url): bool;
}
