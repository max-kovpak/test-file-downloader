<?php

namespace App\Http\Controllers\Api;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileStoreRequest;
use App\Jobs\DownloadFile;
use App\Repositories\FileRepository;
use Illuminate\Http\Response;

class FilesController extends Controller
{
    /**
     * @var FileRepository
     */
    protected $repo;

    /**
     * @param FileRepository $repo
     */
    public function __construct(FileRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return response()->json(File::all());
    }

    /**
     * @param File $file
     *
     * @return Response
     */
    public function show(File $file)
    {
        return response()->json($file);
    }

    /**
     * @param FileStoreRequest $request
     *
     * @return Response
     */
    public function store(FileStoreRequest $request)
    {
        $file = $this->repo->create($request->get('url'));

        DownloadFile::dispatch($file);

        return response()->json($file);
    }
}
