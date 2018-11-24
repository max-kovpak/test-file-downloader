<?php

namespace App\Console\Commands;

use App\File;
use App\Interfaces\FileDownloaderInterface;
use App\Repositories\FileRepository;
use Illuminate\Console\Command;
use App\Jobs\DownloadFile as DownloadFileJob;

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
        $url = $this->argument('url');

        $validator = \Validator::make(
            ['url' => $url],
            ['url' => 'url']
        );

        if ($validator->fails()) {
            $this->error(implode("\n", $validator->messages()->all()));

            return;
        }

        $file = app(FileRepository::class)->create($url);

        DownloadFileJob::dispatch($file);

        $this->line('File was queued for downloading.');
    }
}
