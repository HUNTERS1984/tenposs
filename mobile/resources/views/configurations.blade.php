@extends('master')
@section('headCSS')
<style>
    body{
        font-size: {{ $app_info->data->app_setting->font_size }};
        font-family: "{{ $app_info->data->app_setting->font_family }}";
    }
    .h_control-nav:before{
        color: #{{ $app_info->data->app_setting->menu_icon_color }};
        }
</style>
<!-- Custom styles for this template -->
<link href="{{ url('css/setting.css') }}" rel="stylesheet">
@endsection
@section('page')
<div id="header">
     <div class="container-fluid" style="background-color:#{{ $app_info->data->app_setting->header_color }};">
        <h1 class="aligncenter" style="
                color: #{{ $app_info->data->app_setting->title_color }};
            ">設定</h1>
         <a href="javascript:void(0)" class="h_control-nav"></a>
    </div>
</div><!-- End header -->
<div id="main">    
    <div id="content">
        <div id="setting">
            <ul>
                <li><a href="{{ route('profile') }}">プロフィール編集</a></li>  
                <li>
                    <a href="#">お知らせを受け取る</a>
                    <!-- Rounded switch -->
                    <label class="switch">
                        <input name="news" type="checkbox" {{ ($configs->news == 1 )? 'checked':'' }}
                        value="{{ $configs->news }}">
                        <div class="slider round"></div>
                    </label>
                </li>
                <li>
                    <a href="#">クーポン情報を受け取る</a>
                    <!-- Rounded switch -->
                    <label class="switch">
                        <input name="coupon" type="checkbox" {{ ($configs->coupon == 1 )? 'checked':'' }}
                        value="{{ $configs->coupon }}">
                        <div class="slider round"></div>
                    </label>
                </li>
                <li><a href="{{ route('company.info') }}">逼営会社</a></li>   
                <li><a href="{{ route('user.privacy') }}">採用情報</a></li>   
                <li><a href="{{ route('logout') }}">ログアウト</a></li> 
               
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