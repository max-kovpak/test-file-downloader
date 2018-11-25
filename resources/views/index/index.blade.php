@extends('layouts.default.layout')

@section('content')

    <div>
        <h1>Download File</h1>

        <form action="#" class="download-file-form" method="post">
            <div class="row">
                <div class="col-8">
                    <input name="url" class="form-control form-control-lg" type="text" placeholder="Put a link to the file.">
                </div>

                <div class="col-4">
                    <button class="btn btn-primary btn-lg submit-btn" type="submit"><i class="fas fa-download"></i> Download</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('.download-file-form').submit(function (e) {
                e.preventDefault();

                var $url = $(this).find('[name=url]');
                var $btn = $(this).find('.submit-btn');
                if (0 === $url.val().length || $btn.hasClass('disabled')) {
                    return;
                }

                $btn.btnLoader('start');

                $.ajax({
                    url: '{{route('files.store')}}',
                    type: 'post',
                    data: {
                        url: $url.val()
                    },
                    success: function (res) {
                        $btn.btnLoader('stop');

                        $url.val('');
                        toastr.success('The file was queued for downloading.');
                    },
                    error: function () {
                        $btn.btnLoader('stop');

                        toastr.error('ERROR');
                    }
                });
            });
        });
    </script>
@endpush