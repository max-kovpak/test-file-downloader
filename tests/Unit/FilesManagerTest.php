<?php

namespace Tests\Unit;

use App\File;
use App\Services\FilesManager;
use App\Utils\TmpFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Filesystem\Filesystem;

class FilesManagerTest extends TestCase
{
    public function testPut()
    {
        /** @var Filesystem $disk */
        $disk = \Storage::disk(config('file_downloader.driver'));
        $filesManager = new FilesManager($disk);

        $tmpFile = new TmpFile();

        file_put_contents($tmpFile->getPath(), '1');

        $path = $filesManager->put($tmpFile);

        $this->assertTrue($disk->exists($path));
        $this->assertTrue($disk->get($path) === '1');

        $disk->delete($path);
        $tmpFile->close();
    }

    public function testGetUrl()
    {
        /** @var Filesystem $disk */
        $disk = \Storage::disk(config('file_downloader.driver'));
        $filesManager = new FilesManager($disk);

        $file = new File();

        //if no real file
        $file->path = '/foo/bar/test.png';
        $url = $filesManager->getUrl($file);
        $this->assertNull($url);

        //if file is real
        $tmpFile = new TmpFile();
        file_put_contents($tmpFile->getPath(), '1');
        $path = $filesManager->put($tmpFile, 'test');
        $file->path = $path;
        $url = $filesManager->getUrl($file);

        $this->assertEquals(env('APP_URL').'/storage/'.$path, $url);

        $tmpFile->close();
    }
}
