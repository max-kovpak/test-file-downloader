<?php

namespace App\Services;

use App\Interfaces\FilesManagerInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\File;

/**
 * {@inheritdoc}
 */
class FilesManager implements FilesManagerInterface
{
    /**
     * @var Filesystem
     */
    protected $fs;

    /**
     * {@inheritdoc}
     */
    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
    }

    /**
     * {@inheritdoc}
     */
    public function writeStream($resource, string $path = ''): string
    {
        $metaData = stream_get_meta_data($resource);
        $file = new File($metaData["uri"]);
        $ext = $file->guessExtension();

        $fileName = md5(microtime(true)).'.'.($ext || 'undefined');

        $path = '/' === substr($path, strlen($path), strlen($path)-1) ? substr($path, 0, strlen($path)-1) : $path;
        $path = $path
            . DIRECTORY_SEPARATOR
            . substr($fileName, 0, 2)
            . DIRECTORY_SEPARATOR
            . substr($fileName, 4, 2);

        if (!$this->fs->exists($path)) {
            $this->fs->makeDirectory($path);
        }

        $filePath = $path
            . DIRECTORY_SEPARATOR
            . $fileName;

        $this->fs->writeStream($filePath, $resource);

        return $filePath;
    }
}
