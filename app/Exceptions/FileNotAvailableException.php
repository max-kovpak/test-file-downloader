<?php

namespace App\Exceptions;

class FileNotAvailableException extends \RuntimeException
{
    protected $message = 'Requested file is not available for downloading.';
}
