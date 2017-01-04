<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Include meta tag to ensure proper rendering and touch zooming -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include jQuery Mobile stylesheets -->
    <link rel="stylesheet" href="{{ Theme::asset('css/jquery.mobile-1.4.5.css')}}">
    <!-- Include the jQuery library -->
    <script src="{{ Theme::asset('js/jquery-1.11.3.min.js')}}"></script>
    <!-- Include the jQuery Mobile library -->
    <script src="{{ Theme::asset('js/jquery.mobile-1.4.5.min.js') }}"></script>
    <link rel="stylesheet" href="{{ Theme::asset('css/jquery.bxslider.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ Theme::asset('css/styles.css') }}" type="text/css" />

    <link rel="manifest" href="{{ url( $app_info->data->app_setting->app_id.'/manifest.json') }}">
    <script src="{{ Theme::asset('js/notification.js') }}"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            notify.init('{{  Theme::asset("js/notification_worker.js") }}');
            @if( Session::has('user') && !Session::get('setpushkey') )
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{  csrf_token() }}'
                    },
                    url: '{{ route("setpushkey") }}',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        key: notify.data.subscribe()
                    },

                    success: function(response){
                        console.log('Setpushkey success');
                    }
                })
                @endif
            });
        
    </script>

    @yield('header')
</head>
<body class="ui-nosvg">
@yield('main')
@include('partials.sidemenu')
@yield('footer')
@include('partials.message')
@if (count($errors) > 0)
<script type="text/javascript">
    $(document).ready(function(){
        $( "#windown-message" ).popup();
        setTimeout(function(){
            $( "#windown-message" ).popup( "open" );
        }, 700);
    });
</script>
@endif

<script>
     $(document).ready(function(){
        $('#outside').css({
            'height' : $('#pageone').height() + 44
        });
     });

</script>

</body>
</html>