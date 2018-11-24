<?php

namespace App\Services;

use App\Interfaces\FilesManagerInterface;
use App\Interfaces\TmpFileInterface;
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
    public function put(TmpFileInterface $file, string $path = ''): string
    {
        $ext = (new File($file->getPath()))->extension();
        $content = $file->getResource();
        if (!is_resource($content) || feof($content)) {
            $content = file_get_contents($file->getPath());
        }

        $fileName = md5(microtime(true)).'.'.$ext;

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

        $this->fs->put($filePath, $content);

        return $filePath;
    }
}
