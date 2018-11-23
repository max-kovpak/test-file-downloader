<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'url', 'path', 'status', 'real_name',
        'mime_type', 'size', 'ext'
    ];
}
