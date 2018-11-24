<?php

namespace App\Providers;

use App\Interfaces\FileDownloaderInterface;
use App\Interfaces\FilesManagerInterface;
use App\Repositories\FileRepository;
use App\Services\FileDownloader;
use App\Services\FilesManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FilesManagerInterface::class, function () {
            return new FilesManager(\Storage::disk(config('file_downloader.driver')));
        });

        $this->app->singleton(FileDownloaderInterface::class, FileDownloader::class);
        $this->app->singleton(FileRepository::class, FileRepository::class);
    }
}
