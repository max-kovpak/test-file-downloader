<?php

namespace App\Interfaces;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\File;

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
     * @param resource $resource
     * @param string   $path
     *
     * @return string
     */
    public function writeStream($resource, string $path = ''): string;
}
