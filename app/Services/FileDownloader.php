<?php

namespace App\Services;

use App\Interfaces\FileDownloaderInterface;
use App\Interfaces\FilesManagerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\File;
use App\DTO\UploadedFile;
use App\Exceptions\FileNotAvailableException;
use GuzzleHttp\Exception\RequestException;

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

        $tmpFile = tempnam(sys_get_temp_dir(), 'fileDownloader_');
        $handle = fopen($tmpFile, 'w');

        $client = new Client([
            RequestOptions::VERIFY  => false,
            RequestOptions::TIMEOUT => $timeout,
            RequestOptions::SINK    => $handle,
            RequestOptions::HEADERS => [
                'User-Agent' => self::USER_AGENT
            ]
        ]);

        try {
            $res = $client->get($url);
        } catch (RequestException $e) {
            fclose($handle);
            @unlink($tmpFile);

            throw new FileNotAvailableException(sprintf('File "%s" is not available.', $url));
        }

        //@todo get file name
        $res->getHeaderLine('');

        $realFileName = null;
        if (!empty($contentDisposition = $res->getHeaderLine('Content-Disposition'))) {
            preg_match('/filename="(.*)"/', $contentDisposition, $matches);
            $realFileName = data_get($matches, '1');
        }

        $filePath = $this->fm->writeStream(
            $handle
        );

        $file = new File($tmpFile);

        $ext = $file->guessExtension();
        $uploadedFile = new UploadedFile(
            $url,
            $filePath,
            $realFileName ?? $file->getBasename(),
            $ext,
            $file->getMimeType(),
            $file->getSize()
        );

        @unlink($tmpFile);

        return $uploadedFile;
    }

    /**
     * {@inheritdoc}
     */
    public function isDownloadable(string $url): bool
    {
        $client = new Client([
            RequestOptions::VERIFY  => false,
            RequestOptions::TIMEOUT => 10,
            RequestOptions::HEADERS => [
                'User-Agent' => self::USER_AGENT
            ],
        ]);

        try {
            $response = $client->get($url, [
                'curl' => [
                    CURLOPT_NOBODY => true
                ]
            ]);
        } catch (RequestException $e) {
            return false;
        }

        return 200 == $response->getStatusCode();
    }
}
