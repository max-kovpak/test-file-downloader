<?php

namespace App\Interfaces;

use Illuminate\Http\File;

interface TmpFileInterface
{
    /**
     * Get resource.
     *
     * @return resource
     */
    public function getResource();

    /**
     * Get tmp file path.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Get File.
     *
     * @return File
     */
    public function getFile(): File;

    /**
     * Close resource and remove tmp file.
     *
     * @return void
     */
    public function close();
}
