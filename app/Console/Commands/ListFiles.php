<?php

namespace App\Console\Commands;

use App\File;
use App\Repositories\FileRepository;
use Illuminate\Console\Command;
use App\Jobs\DownloadFile as DownloadFileJob;

class ListFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:file:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the list of files.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = File::orderBy('id', 'desc')->get();

        $headers = [
            'ID', 'URL', 'Status', 'Path', 'Download'
        ];

        $data = $files->map(function (File $file) {
            return [
                'id'       => $file->getKey(),
                'url'      => $file->url,
                'status'   => $file->status,
                'path'     => $file->path,
                'download' => $file->download_url,
            ];
        })->toArray();

        $this->table($headers, $data);
    }
}
