<?php

namespace App\DTO;

class UploadedFile
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $ext;

    /**
     * @var string
     */
    protected $mimeType;

    /**
     * @var int
     */
    protected $size;

    /**
     * UploadedFile constructor.
     *
     * @param string $url
     * @param string $path
     * @param string $name
     * @param string $ext
     * @param string $mimeType
     * @param int    $size
     */
    public function __construct(string $url, string $path, string $name, string $ext, string $mimeType, int $size)
    {
        $this->url = $url;
        $this->path = $path;
        $this->name = $name;
        $this->ext = $ext;
        $this->mimeType = $mimeType;
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getExt(): string
    {
        return $this->ext;
    }

    /**
     * @param string $ext
     */
    public function setExt(string $ext)
    {
        $this->ext = $ext;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size)
    {
        $this->size = $size;
    }
}
