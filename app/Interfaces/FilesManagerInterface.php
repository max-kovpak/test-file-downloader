<?php

namespace App\Interfaces;

use Illuminate\Contracts\Filesystem\Filesystem;
use App\File;

/**
 * Interface FilesManagerInterface
 *
 * @package App\Interfaces
 */
interface FilesManagerInterface
{
    /**
     * FilesManager constructor.
     *
     * @param Filesystem $fs
     */
    public function __construct(Filesystem $fs);

    /**
     * Create new file from a stream.
     *
     * @param TmpFileInterface $file
     * @param string           $path
     *
     * @return string
     */
    public function put(TmpFileInterface $file, string $path = ''): string;

    /**
     * Get URL to the file.
     *
     * @param File $file
     *
     * @return string|null
     */
    public function getUrl(File $file);
}
