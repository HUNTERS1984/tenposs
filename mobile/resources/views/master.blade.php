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
    <link rel="manifest" href="{{ url('manifest.json') }}">
    <title>Tenpo</title>
    
    <link href="{{ url('fonts/themify/themify-icons.css') }}" rel="stylesheet">
    
    <!-- Bootstrap core CSS -->
    <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Slider swiper core CSS -->
    <link href="{{ url('css/swiper.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ url('css/reset.css') }}" rel="stylesheet">
    
    <!-- Custom common for this template -->
    <link href="{{ url('css/common.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ url('css/main.css') }}" rel="stylesheet">
    
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
        <script src="{{ url('js/jquery.min.js') }}"></script>
        <script src="{{ url('js/bootstrap.min.js') }}"></script>
        <script src="{{ url('js/swiper.jquery.min.js') }}"></script>
        <script src="{{ url('js/script.js') }}"></script>
        <script src="{{ url('js/notification.js') }}"></script>
        <script type="application/javascript">
            $(document).ready(function () {
                notify.init('{{ url("js/notification_worker.js") }}');
            });
        </script>

        @yield('footerJS')
    </body>
</html>

