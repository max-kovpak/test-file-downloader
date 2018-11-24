<?php

namespace App\Services;

use App\Interfaces\FileDownloaderInterface;
use App\Interfaces\FilesManagerInterface;
use App\Interfaces\TmpFileInterface;
use App\Utils\TmpFile;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\File;
use App\DTO\UploadedFile;
use App\Exceptions\FileNotAvailableException;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FileDownloader.
 *
 * @package App\Services
 */
class FileDownloader implements FileDownloaderInterface
{
    const USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36';

    /**
     * @var FilesManagerInterface
     */
    protected $fm;

    /**
     * FileDownloader constructor.
     *
     * @param FilesManagerInterface $fm
     */
    public function __construct(FilesManagerInterface $fm)
    {
        $this->fm = $fm;
    }

    /**
     * {@inheritdoc}
     */
    public function download(string $url, int $timeout = 30): UploadedFile
    {
        if (!$this->isDownloadable($url)) {
            throw new FileNotAvailableException(sprintf('File "%s" is not available.', $url));
        }

        $tmpFile = $this->createTmpFile();
        $client = $this->createClient();

        try {
            $res = $client->get(
                $url,
                [
                    RequestOptions::SINK    => $tmpFile->getResource(),
                    RequestOptions::TIMEOUT => $timeout
                ]
            );
        } catch (RequestException $e) {
            $tmpFile->close();

            throw new FileNotAvailableException(sprintf('File "%s" is not available.', $url));
        }

        $cdHeader = $res->getHeaderLine('Content-Disposition');
        $realFileName = $this->parseFilenameFromContentDisposition($cdHeader);

        $filePath = $this->fm->put($tmpFile);

        $file = $tmpFile->getFile();
        $uploadedFile = $this->createUploadedFile(
            $url,
            $filePath,
            $realFileName,
            $file->guessExtension(),
            $file->getMimeType(),
            $file->getSize()
        );

        $tmpFile->close();

        return $uploadedFile;
    }

    /**
     * {@inheritdoc}
     */
    public function isDownloadable(string $url): bool
    {
        $client = $this->createClient();

        try {
            $response = $client->get(
                $url,
                [
                    RequestOptions::TIMEOUT => 30,
                    'curl'                  => [
                        CURLOPT_NOBODY => true
                    ]
                ]
            );
        } catch (RequestException $e) {
            return false;
        }

        return Response::HTTP_OK == $response->getStatusCode();
    }

    /**
     * Create TmpFileInterface instance.
     *
     * @return TmpFileInterface
     */
    public function createTmpFile(): TmpFileInterface
    {
        return new TmpFile();
    }

    /**
     * Create UploadedFile instance.
     *
     * @param string $url
     * @param string $path
     * @param string $name
     * @param string $ext
     * @param string $mimeType
     * @param int    $size
     *
     * @return UploadedFile
     */
    protected function createUploadedFile(
        string $url = null,
        string $path = null,
        string $name = null,
        string $ext = null,
        string $mimeType = null,
        int    $size = null
    ) {
        return new UploadedFile(
            $url,
            $path,
            $name,
            $ext,
            $mimeType,
            $size
        );
    }

    /**
     * Parse Content-Disposition header and return file name.
     *
     * @param string $contentDisposition
     *
     * @return string
     */
    protected function parseFilenameFromContentDisposition(string $contentDisposition): string
    {
        $fileName = '';
        if (!empty($contentDisposition)) {
            preg_match('/filename[^;=\n]*=(([\'"]).*?\2|[^;\n]*)/', $contentDisposition, $matches);
            $fileName = data_get($matches, '1', '');
        }

        return $fileName;
    }

    /**
     * Create Guzzle Client instance.
     *
     * @return Client
     */
    protected function createClient()
    {
        return new Client(
            [
                RequestOptions::VERIFY  => false,
                RequestOptions::TIMEOUT => 30,
                RequestOptions::HEADERS => [
                    'User-Agent' => self::USER_AGENT
                ],
            ]
        );
    }
}
