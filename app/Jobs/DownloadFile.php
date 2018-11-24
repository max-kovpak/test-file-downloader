<?php

namespace App\Jobs;

use App\Exceptions\FileNotAvailableException;
use App\File;
use App\Interfaces\FileDownloaderInterface;
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
     *
     * @return void
     */
    public function handle(FileDownloaderInterface $fd)
    {
        try {
            $uploadedFile = $fd->download($this->file->url);
            $status = File::STATUS_SUCCESS;
        } catch (FileNotAvailableException $e) {
            $status = File::STATUS_ERROR;
        }

        $this->file->update([
            'real_name' => $uploadedFile->getName(),
            'mime_type' => $uploadedFile->getMimeType(),
            'size'      => $uploadedFile->getSize(),
            'ext'       => $uploadedFile->getExt(),
            'status'    => $status
        ]);
    }
}
