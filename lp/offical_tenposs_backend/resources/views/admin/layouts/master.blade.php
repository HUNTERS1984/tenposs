<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>トップ</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" >
    <link href="{{ url('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('admin/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('admin/css/style.css') }}" rel="stylesheet" type="text/css" />
    
    @yield('headCSS')
</head>
<body class="skin-black">
    
    @include('admin.layouts.header')
   

    <div class="wrapper row-offcanvas row-offcanvas-left">

        @include('admin.layouts.sidebar')
        <!-- /.left-side -->
        @yield('main')
        
    </div><!-- ./wrapper -->

    <script src="{{ url('admin/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('admin/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('admin/js/app.js') }}" type="text/javascript"></script>
    @yield('footerJS')
    {{Html::script('admin/js/trumbowyg/trumbowyg.min.js')}}
    {{Html::style('admin/js/trumbowyg/ui/trumbowyg.min.css')}}
    <script>
        $(document).ready(function(){
            $('textarea').trumbowyg();
        })
    </script>
</body>
</html>