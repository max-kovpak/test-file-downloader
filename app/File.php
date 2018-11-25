<?php

namespace App;

use App\Interfaces\FilesManagerInterface;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_DOWNLOADING = 'downloading';
    const STATUS_COMPLETE = 'complete';
    const STATUS_ERROR = 'error';

    protected $fillable = [
        'url', 'path', 'status', 'real_name',
        'mime_type', 'size', 'ext'
    ];

    protected $appends = [
        'download_url'
    ];

    public function getDownloadUrlAttribute()
    {
        return app(FilesManagerInterface::class)->getUrl($this);
    }
}
