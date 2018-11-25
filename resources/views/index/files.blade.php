@extends('layouts.default.layout')

@section('content')

    <div>
        <h1>Files</h1>

        <div class="table-responsive">
            <table class="table table stripped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Download</th>
                </tr>
                </thead>
                <tbody>
                @foreach($files as $file)
                    <tr>
                        <td>{{$file->getKey()}}</td>
                        <td>{{$file->url}}</td>
                        <td>{{title_case($file->status)}}</td>
                        <td>
                            @if(\App\File::STATUS_COMPLETE === $file->status)
                                <a target="_blank" class="btn btn-light" href="{{$file->download_url}}"><i class="fas fa-download"></i> Download</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection