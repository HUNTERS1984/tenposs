<!DOCTYPE html>
<html lang="en">

    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ url('favicon.ico') }}">
    <link rel="manifest" href="{{ url( $app_info->data->app_setting->app_id.'/manifest.json') }}">
    <title>Tenpo</title>
    
    <link href="{{ Theme::asset('fonts/themify/themify-icons.css') }}" rel="stylesheet">
    
    <!-- Bootstrap core CSS -->
    <link href="{{ Theme::asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Slider swiper core CSS -->
    <link href="{{ Theme::asset('css//swiper.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ Theme::asset('css/reset.css') }}" rel="stylesheet">
    
    <!-- Custom common for this template -->
    <link href="{{ Theme::asset('css/common.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ Theme::asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ Theme::asset('css/fix.css') }}" rel="stylesheet">
    @yield('headCSS')

    <body>
        <div class="wrap">
            <div id="page">
                <div class="overfog"></div>
                @yield('page')
            </div>
        </div><!-- End wrap -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="{{ Theme::asset('js/jquery.min.js') }}"></script>
        <script src="{{ Theme::asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ Theme::asset('js/swiper.jquery.min.js') }}"></script>
        <script src="{{ Theme::asset('js/script.js') }}"></script>
        <script src="{{ Theme::asset('js/notification.js') }}"></script>
        <script type="application/javascript">
            $(document).ready(function () {
                notify.init('{{ url("js/notification_worker.js") }}');
                @if (count($errors) > 0)
                $('#modal-message').modal();
                @endif
            });
        </script>

        @yield('footerJS')
    </body>
</html>

