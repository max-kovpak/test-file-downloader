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
    public function getPath();

    /**
     * Get File.
     *
     * @return File
     */
    public function getFile();

    /**
     * Close resource and remove tmp file.
     *
     * @return void
     */
    public function close();
}
