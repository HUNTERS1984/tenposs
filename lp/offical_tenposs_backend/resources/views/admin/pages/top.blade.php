@extends('admin.layouts.master')

@section('main')
<form class="form-top" id="form_app_setting" method="post" action="{{ route('admin.client.top.store') }}">
    {{ csrf_field() }}
    <aside class="right-side">
        <div class="wrapp-breadcrumds">
            <div class="left"><span>トップ</span></div>
            <div class="right">
                <a href="#" id="btn_submit_form" class="btn-2">保存</a>
            </div>
        </div>
        <section class="content">
            <div class="col-xs-12">@include('admin.layouts.messages')</div>
            
            <div class="col-md-4">
                <div class="wrap-preview top">
                    <div class="wrap-content-prview">
                        <div class="scroller scrollbar-macosx">
                            <div class="header-preview">
                                <a href="javascript:avoid()" class="trigger-preview"><img
                                            src="/assets/backend/images/nav-icon.png" alt=""></a>
                                <h2 class="title-prview">ホーム</h2>
                            </div>
                            <div class="content-preview" id="session">
                            </div>
                            <div class="template" style="display:none">
                                @include('admin.pages.top_1')
                                @include('admin.pages.top_2')
                                @include('admin.pages.top_3')
                                @include('admin.pages.top_4')
                                @include('admin.pages.top_5')        
                            </div>
                        </div>
                    </div>
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
    {{Html::script('admin/js/swiper/swiper.jquery.min.js')}}
    {{Html::style('admin/js/swiper/swiper.min.css')}}
    {{Html::script('admin/js/plugins/jquery.scrollbar/jquery.scrollbar.min.js')}}
    {{Html::script('admin/js/plugins/maps/jquery.googlemap.js')}}
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrEF9NEPkuxtYouSqVqNj3KSoX__7Rm8g"></script>
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

    }
    $(document).ready(function () {
        $('.scroller').scrollbar();
        $('.nav-left, .nav-right').on('click', 'li', function (e) {
            e.preventDefault();
            $(this).toggleClass('selected');
            $(this).find('a').toggleClass('active');
        });


                
        $('.nav-left li').each(function(index,item){
            var html = $('#template-'+$(item).attr('data-value')).html();
            $('#session').append(html);

            var bannerSwiper = new Swiper('.swiper-container', {
                autoplay: 2000,
                speed: 400,
                loop: true,
                spaceBetween: 0,
                slidesPerView: 1,
                pagination: ".swiper-pagination",
                paginationClickable: true
            });
           
        })

        $(maps).each(function(index, item){
            $("#map-"+item.id).googleMap();
            $("#map-"+item.id).addMarker({
              coords: [item.lat,item.long], // GPS coords
              title: item.title, // Title
              text: item.title
            });
        });
        
        
        
    });
    
</script>

@endsection