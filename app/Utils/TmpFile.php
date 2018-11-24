<?php

namespace App\Utils;

use App\Interfaces\TmpFileInterface;
use Illuminate\Http\File;

class TmpFile implements TmpFileInterface
{
    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var resource
     */
    protected $resource;

    /**
     * @var resource
     */
    protected $metaData;

    /**
     * TmpFile Constructor.
     */
    public function __construct()
    {
        $this->filePath = tempnam(sys_get_temp_dir(), 'fileDownloader_');
        $this->resource = fopen($this->filePath, 'w');
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->filePath;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function getFile()
    {
        return new File($this->filePath);
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        @fclose($this->resource);
        @unlink($this->filePath);
    }
}
