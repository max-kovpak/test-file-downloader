<?php

namespace App\Console\Commands;

use App\Interfaces\FileDownloaderInterface;
use Illuminate\Console\Command;

class DownloadFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:download-file
                            {url : URL to the file.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download a file by url.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fd = app(FileDownloaderInterface::class);
        $url = $this->argument('url');

        if (empty($url)) {
            throw new \InvalidArgumentException('URL is required');
        }

        //@todo put a job to queue

        $file = $fd->download($url);

        dd($file);
    }
}
