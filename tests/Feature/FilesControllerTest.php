<?php

namespace Tests\Feature;

use App\File;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilesControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/files');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
            ]);
        ;
    }

    public function testStoreInvalid()
    {
        $response = $this->json('POST', '/api/files', [
            'url' => 'test'
        ]);

        $response->assertStatus(422);
    }

    public function testStoreValid()
    {
        $response = $this->json('POST', '/api/files', [
            'url' => 'https://s.gravatar.com/avatar/9ec4a7300ccf8fda2a5a25af3bf898be?s=200'
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'url', 'status', 'real_name', 'mime_type',
                'size', 'ext', 'download_url', 'created_at', 'updated_at'
            ])
            ->assertJson(['status' => File::STATUS_PENDING])
        ;
    }

    public function testShow()
    {
        $this->json('POST', '/api/files', [
            'url' => 'https://s.gravatar.com/avatar/9ec4a7300ccf8fda2a5a25af3bf898be?s=200'
        ]);

        $file = File::first();
        $response = $this->get('/api/files/'.$file->getKey());

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 'url', 'status', 'real_name', 'mime_type',
                'size', 'ext', 'download_url', 'created_at', 'updated_at'
            ])
        ;
    }
}
