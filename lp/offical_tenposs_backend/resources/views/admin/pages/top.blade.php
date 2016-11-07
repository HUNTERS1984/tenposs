@extends('admin.layouts.master')

@section('main')
<form class="form-top" id="form_app_setting" method="post" action="{{ route('admin.client.top.store') }}">
    {{ csrf_field() }}
    <aside class="right-side">
        <div class="wrapp-breadcrumds">
            <div class="left"><span>トップ</span></div>
            <div class="right">
                <a id="btn_submit_form" class="btn-2">保存</a>
            </div>
        </div>
        <section class="content">
            <div class="col-xs-12">@include('admin.layouts.messages')</div>
            
            <div class="col-md-4">
                <div class="wrapp-phone">
                    <center>
                        <img src="images/phone.jpg" class="img-responsive" alt="">
                    </center>
                </div>
            </div>
            <div class="col-md-8">
                
                    <div class="form-group">
                        <label>オンライン</label>
                        <select name="" id="" class="form-control short">
                            <option value="">オンライン</option>
                            <option value="">オンライン</option>
                            <option value="">オンライン</option>
                            <option value="">オンライン</option>
                            <option value="">オンライン</option>
                        </select>
                        <a href="" class="link-top-1" title="">+ ユーザーネーム</a>
                    </div>
                    <div class="form-group arrow-select">
                        <label>トップページ表示項目</label>
                        <div class="wrapp-arrow-select">
                            <div class="wrap-table-top">
                                <div class="wrap-transfer col">
                                    <p class="title-form">表示</p>
                                    <ul class="nav-left link-top-2">
                                        @if(!is_null($app_components))
                                            @foreach ($app_components as $key => $value)
                                                <li data-id="{{$key}}" data-value="{{$key}}">
                                                    <a href="#">{{$value}}</a></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="wrap-btn-control col">
                                    <a href="javascript:moveTo('nav-left','nav-right')">
                                        <span class="fa fa-caret-right"></span>
                                    </a>
                                    <a href="javascript:moveTo('nav-right','nav-left')">
                                        <span class="fa fa-caret-left"></span>
                                    </a>
                                </div>
                                <div class="wrap-transfer col">
                                    <p class="title-form">非表示</p>
                                    <ul class="nav-right link-top-2">
                                        @if(!is_null($available_components))
                                            @foreach ($available_components as $key => $value)
    
                                            <li data-id="{{$key}}" data-value="{{$key}}">
                                                <a href="#">{{$value}}</a></li>
                                            @endforeach
                                        @endif
                                       
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>                
        </section>
    </aside>
</form>
@endsection    

@section('footerJS')
<script type="text/javascript">
    
    $('#btn_submit_form').click(function () {
        $('ul.nav-left li').each(function () {
            var tmp = '<input type="hidden" value="' + $(this).data('value') + '"  name="data_component[]">';
            $('#form_app_setting').append(tmp);
        });
        $('#form_app_setting').submit();
    });

    function moveTo(from, to) {
            
        $('ul.' + from + ' li.selected').remove().appendTo('ul.' + to);
        $('.' + to + ' li').removeAttr('class');
        $('.' + to + ' li a').removeAttr('class');
        /*
        $('div[id^=mobile]').hide();
        $('.nav-left li').each(function(index,item){
            $('#mobile-'+$(item).attr('data-value')).show();
        })*/
    }
    $(document).ready(function () {
        $('.nav-left, .nav-right').on('click', 'li', function (e) {
            e.preventDefault();
            $(this).toggleClass('selected');
            $(this).find('a').toggleClass('active');
        });
        
        
        
    });
    
</script>

@endsection