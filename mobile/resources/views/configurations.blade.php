@extends('master')
@section('headCSS')
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: "{{ $app_info->data->app_setting->font_family }}";
    }
</style>
<!-- Custom styles for this template -->
<link href="{{ url('css/setting.css') }}" rel="stylesheet">
@endsection
@section('page')
<div id="header">
    <div class="container-fluid">
        <h1 class="aligncenter" style="
            color: #{{ $app_info->data->app_setting->title_color}};
            background-color: #{{ $app_info->data->app_setting->header_color}};
            ">設定</h1>
        <a href="javascript:void(0)" class="h_control-nav">
            <img src="img/icon/h_nav.png" alt="nav"/>
        </a>
    </div>
</div><!-- End header -->
<div id="main">    
    <div id="content">
        <div id="setting">
            <ul>
                <li><a href="{{ route('profile') }}">プロフィール編集</a></li>  
                <li>
                    <a href="#">ランキング</a>
                    <!-- Rounded switch -->
                    <label class="switch">
                        <input name="ranking" type="checkbox" {{ ($configs->data->push_setting->ranking == 1 )? 'checked':'' }} 
                        value="{{ $configs->data->push_setting->ranking }}">
                        <div class="slider round"></div>
                    </label>
                </li>
                <li>
                    <a href="#">ニュース</a>
                    <!-- Rounded switch -->
                    <label class="switch">
                        <input name="news" type="checkbox" {{ ($configs->data->push_setting->news == 1 )? 'checked':'' }} 
                        value="{{ $configs->data->push_setting->news }}">
                        <div class="slider round"></div>
                    </label>
                </li>
                <li>
                    <a href="#">クーポン</a>
                    <!-- Rounded switch -->
                    <label class="switch">
                        <input name="coupon" type="checkbox" {{ ($configs->data->push_setting->coupon == 1 )? 'checked':'' }} 
                        value="{{ $configs->data->push_setting->coupon }}">
                        <div class="slider round"></div>
                    </label>
                </li>
                <li>
                    <a href="#">チャット</a>
                    <!-- Rounded switch -->
                    <label class="switch">
                        <input name="chat" type="checkbox" {{ ($configs->data->push_setting->chat == 1 )? 'checked':'' }} 
                        value="{{ $configs->data->push_setting->chat }}">
                        <div class="slider round"></div>
                    </label>
                </li>
                   
                <li><a href="{{ route('company.info') }}">逼営会社</a></li>   
                <li><a href="{{ route('user.privacy') }}">採用情報</a></li>   
               
            </ul>
        </div>
    </div>     
    @include('partials.sidemenu')
</div><!-- End main -->    
@endsection

@section('footerJS')
<script type="text/javascript">
    $('input[type="checkbox"]').on('change',function(){
        
        var params = [];
        $('input[type="checkbox"]').each(function(index, item){
            params.push(
                {
                    name: $(item).attr('name'),
                    value: $(item).is(':checked')
                }    
            )
        });
 
        $.ajax({
            url: '{{ route("configuration.save") }}',
            dataType: 'json',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': '{{  csrf_token() }}'
            },
            data: params,
            success: function( response ){
                console.log(response);
            }
        })
       
    })
</script>
    
@endsection