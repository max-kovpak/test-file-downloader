<?php

namespace App\Http\Controllers;

use App\File;

class IndexController extends Controller
{
    /**
     * Home page & put file to the queue.
     */
    public function index()
    {
        return view('index.index');
    }

    /**
     * View the list of files with statuses & ability to download completed items.
     */
    public function files()
    {
        $files = File::orderBy('id', 'desc')->get();

        return view('index.files', [
            'files' => $files
        ]);
    }
}
