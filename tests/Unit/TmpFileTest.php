<?php

namespace Tests\Feature;

use App\Utils\TmpFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TmpFileTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTmpFile()
    {
        $tmpFile = new TmpFile();

        $path = $tmpFile->getPath();
        $res = $tmpFile->getResource();

        $this->assertTrue(file_exists($path) && is_file($path));
        $this->assertTrue(is_resource($res) && !feof($res));

        $tmpFile->close();

        $this->assertTrue(!file_exists($path) || !is_file($path));
        $this->assertTrue(!is_resource($res) || feof($res));
    }
}
