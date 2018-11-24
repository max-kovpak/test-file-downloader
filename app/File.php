<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    const STATUS_QUEUED = 'queued';
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';

    protected $fillable = [
        'url', 'path', 'status', 'real_name',
        'mime_type', 'size', 'ext'
    ];
}
