<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('index.index');
    }

    public function files()
    {
        $files = File::orderBy('id', 'desc')->get();

        return view('index.files', [
            'files' => $files
        ]);
    }
}
