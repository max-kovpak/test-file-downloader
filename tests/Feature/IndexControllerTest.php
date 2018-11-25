<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexControllerTest extends TestCase
{
    public function testIndex()
    {
        $res = $this->get('/');

        $res->assertStatus(200);
    }

    public function testFiles()
    {
        $res = $this->get('/files');

        $res->assertStatus(200);
    }
}
