<?php

namespace App\Http\Controllers\Api;

use App\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileStoreRequest;
use App\Http\Resources\FileResource;
use App\Jobs\DownloadFile;
use App\Repositories\FileRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

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
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return FileResource::collection(File::orderBy('id', 'desc')->get());
    }

    /**
     * @param File $file
     *
     * @return FileResource
     */
    public function show(File $file)
    {
        return response()->json(new FileResource($file));
    }

    /**
     * @param FileStoreRequest $request
     *
     * @return FileResource
     */
    public function store(FileStoreRequest $request)
    {
        $file = $this->repo->create($request->get('url'));

        DownloadFile::dispatch($file);

        return response()->json(new FileResource($file), Response::HTTP_CREATED);
    }
}
