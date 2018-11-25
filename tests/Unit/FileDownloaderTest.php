<?php

namespace Tests\Unit;

use App\Exceptions\FileNotAvailableException;
use App\Interfaces\TmpFileInterface;
use App\Services\FileDownloader;
use App\Services\FilesManager;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Filesystem\Filesystem;

class FileDownloaderTest extends TestCase
{
    public function testCreateTmpFile()
    {
        /** @var Filesystem $disk */
        $disk = \Storage::disk(config('file_downloader.driver'));
        $fm = new FilesManager($disk);
        $fd = new FileDownloader($fm);
        $tmpFile = $fd->createTmpFile();

        $this->assertInstanceOf(TmpFileInterface::class, $tmpFile);
    }

    public function testDownloadSuccess()
    {
        /** @var Filesystem $disk */
        $disk = \Storage::disk(config('file_downloader.driver'));
        $fm = new FilesManager($disk);
        $fd = new FileDownloader($fm);

        $uploadedFile = $fd->download('https://s.gravatar.com/avatar/9ec4a7300ccf8fda2a5a25af3bf898be?s=200');

        $this->assertTrue($disk->exists($uploadedFile->getPath()));

        $disk->delete($uploadedFile->getPath());
    }

    public function testDownloadError()
    {
        /** @var Filesystem $disk */
        $disk = \Storage::disk(config('file_downloader.driver'));
        $fm = new FilesManager($disk);
        $fd = new FileDownloader($fm);

        $this->expectException(FileNotAvailableException::class);
        $fd->download('https://max-kovpak.com/404');
    }

    public function testIsDownloadable()
    {
        /** @var Filesystem $disk */
        $disk = \Storage::disk(config('file_downloader.driver'));
        $fm = new FilesManager($disk);
        $fd = new FileDownloader($fm);

        $res = $fd->isDownloadable('https://s.gravatar.com/avatar/9ec4a7300ccf8fda2a5a25af3bf898be?s=200');

        $this->assertTrue($res);

        $res = $fd->isDownloadable('https://max-kovpak.com/404');
        $this->assertFalse($res);
    }
}
