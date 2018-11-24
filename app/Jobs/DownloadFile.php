<?php

namespace App\Jobs;

use App\Exceptions\FileNotAvailableException;
use App\File;
use App\Interfaces\FileDownloaderInterface;
use App\Repositories\FileRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DownloadFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var File $file
     */
    protected $file;

    /**
     * Create a new job instance.
     *
     * @param File $file
     *
     * @return void
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @param FileDownloaderInterface $fd
     * @param FileRepository          $repo
     *
     * @return void
     */
    public function handle(FileDownloaderInterface $fd, FileRepository $repo)
    {
        try {
            $uploadedFile = $fd->download($this->file->url);
            $repo->success($this->file, $uploadedFile);
        } catch (FileNotAvailableException $e) {
            $repo->error($this->file);
        }
    }
}
