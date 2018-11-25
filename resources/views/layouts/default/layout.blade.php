<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>File Downloader</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<body>
    <div class="container">
        @include('layouts.default._header')

        @yield('content')
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        $(function () {
            $.fn.btnLoader = function (action) {
                if (!this || !this.length || $.type(this) !== 'object')
                    return null;

                action = action ? action.toLowerCase() : 'start';

                if (!$('#btn-loader-styles').length) {
                    var styles = '<style id="btn-loader-styles">.st-btn-loader{position: relative;}.st-btn-loader:after{background: url("data:image/gif;base64,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") no-repeat scroll center center #FFFFFF;opacity: 0.33;cursor: default; color: #FF0000; content: " "; height: 100%; left: 0;position: absolute;top: 0;width: 100%;z-index: 1;}</style>';
                    $('body').append(styles);
                }

                if (action === 'start') {
                    this.addClass('st-btn-loader');
                    this.attr('disabled', true).prop('disabled', true).addClass('disabled');
                } else if (action === 'stop') {
                    this.removeClass('st-btn-loader');
                    this.attr('disabled', false).prop('disabled', false).removeClass('disabled');
                }

                return this;
            };
        });
    </script>

    @stack('scripts')
</body>
</html>