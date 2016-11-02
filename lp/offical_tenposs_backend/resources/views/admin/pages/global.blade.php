@extends('admin.layouts.master')

@section('main')

<form action="{{ route('admin.client.global.store') }}" 
            id="form_app_setting"
            method="post" 
            enctype="multipart/form-data">
    
  {{ csrf_field() }}   
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left"><span>グローバル</span></div>
        <div class="right">
         
            <button type="submit" class="btn-2">ポ覧</button>
        </div>
    </div>
    <section class="content">
        @include('admin.layouts.messages')
        <div class="col-md-12">
            <div class="tab-header-global">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation">
                        <a href="#tab-global-1" aria-controls="tab-global-1" role="tab" data-toggle="tab">ヘッダー</a>
                    </li>
                    <li role="presentation">
                        <a href="#tab-global-2" aria-controls="tab-global-2" role="tab" data-toggle="tab">サイトメニュー</a>
                    </li>
                    <li role="presentation" class="active">
                        <a href="#tab-global-3" aria-controls="tab-global-3" role="tab" data-toggle="tab">Appストア</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content">

            <div role="tabpanel" class="tab-pane active" id="tab-global-1">
                <div class="col-md-4">
                    <div class="wrapp-phone">
                        <center>
                            <img src="images/phone.jpg" class="img-responsive" alt="">
                        </center>
                    </div>
                </div>
                <div class="col-md-8">
                    
                        <div class="form-group">
                            <label>タイトル</label>
                            {{Form::text('title',$app_settings->title,
                                        array('class'=>'form-control middle', 'placeholder'=>'タイトル'))}}
                            
                        </div>
                        <div class="form-group">
                            <label>タイトルカラー</label>
                            <div class="wrapp-draw">
                                
                                {{Form::text('title_color',$app_settings->title_color
                                        ,array('id'=>'title_color','class'=>'form-control supper-short jscolor', 'placeholder'=>''))}}
                                <img onclick="document.getElementById('title_color').jscolor.show()" 
                                                src="{{ url('admin/images/draw.jpg') }}" 
                                                class="left"></span>
                               
                            </div>
                        </div>
                        <div class="form-group">
                            <label>フォントタイプ・フォントファミリ</label>
                            <div class="two-select">
                                @if(count($list_font_size) > 0)
                                    {{Form::select('font_size',$list_font_size,$app_settings->font_size,['class'=>'form-control short-1'])}}
                                @endif
                                @if(count($list_font_family) > 0)
                                    {{Form::select('font_family',$list_font_family,$app_settings->font_family,['class'=>'form-control short-2'])}}
                                @endif
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ヘッダーカラー</label>
                            <div class="wrapp-draw">
                                
                                {{Form::text('header_color',$app_settings->header_color,
                                        array('id'=>'header_color','class'=>'form-control supper-short jscolor', 'placeholder'=>''))}}
                                <img onclick="document.getElementById('header_color').jscolor.show()"
                                                src="/assets/backend/images/draw.jpg" 
                                                class="left">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>メニューイコンカラー</label>
                            <div class="wrapp-draw">
                               
                                {{Form::text('menu_icon_color',$app_settings->menu_icon_color,
                                        array('id'=>'menu_icon_color','class'=>'jscolor form-control supper-short', 'placeholder'=>''))}}

                                <img    onclick="document.getElementById('menu_icon_color').jscolor.show()"
                                                src="/assets/backend/images/draw.jpg"
                                                class="left"></span>
                                
                            </div>
                        </div>
                                               
                </div>
            </div>
            <!-- //tab-global-1 -->

            <div role="tabpanel" class="tab-pane" id="tab-global-2">
                <div class="col-md-4">
                    <div class="wrapp-phone">
                        <center>
                            <img src="images/phone.jpg" class="img-responsive" alt="">
                        </center>
                    </div>
                </div>
                <div class="col-md-8">
                  
                        <div class="form-group">
                            <label>バックグラウンドカラー</label>
                            <div class="wrapp-draw">
                                
                                {{Form::text('menu_background_color',$app_settings->menu_background_color,
                                    array(
                                    'id'=>'menu_background_color',
                                    'class'=>'form-control supper-short jscolor {onFineChange:"MobileView.updateMenuBackground(this)"}', 
                                    'placeholder'=>'')
                                    
                                    )}}

                                    <img  onclick="document.getElementById('menu_background_color').jscolor.show()"
                                        src="/assets/backend/images/draw.jpg"
                                        class="left">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>フォントカラー</label>
                            <div class="wrapp-draw">

                                {{Form::text('menu_font_color',$app_settings->menu_font_color,
                                    array('id'=>'menu_font_color', 
                                    'class'=>'form-control supper-short jscolor {onFineChange:"MobileView.updateMenuColor(this)"}',
                                    'placeholder'=>''))}}

                                    <img onclick="document.getElementById('menu_font_color').jscolor.show()"
                                         src="/assets/backend/images/draw.jpg"
                                         class="left">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>フォントタイプ・フォントファミリ</label>
                            <div class="two-select">
                                @if(count($list_font_size) > 0)
                                    {{Form::select('menu_font_size',$list_font_size,$app_settings->menu_font_size,
                                    [
                                        'class'=>'form-control short-1',
                                        'onchange' => 'MobileView.updateMenuFontSize(this.value)'
                                    ])}}
                                @endif
                                @if(count($list_font_family) > 0)
                                    {{Form::select('menu_font_family',$list_font_family,$app_settings->menu_font_family,
                                    [
                                        'class'=>'form-control short-2',
                                        'onchange' => 'MobileView.updateMenuFontFamily(this.value)'
                                    ])}}
                                @endif
                                
                            </div>
                        </div>
                        <div class="form-group arrow-select">
                            <label>サイトメニュー項目</label>
                            <div class="wrapp-arrow-select">
                                <div class="wrap-table-top">
                                    <div class="wrap-transfer col">
                                        <p class="title-form">表示</p>
                                        <ul class="nav-left link-top-2">
                                             @if(count($data_component_dest) > 0)
                                                @foreach ($data_component_dest as $k=>$v)
                                                <li data-id="{{$v->id}}" data-value="{{$v->id}}">
                                                    <a href="#">{{$v->name}}</a></li>
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
                                            @if(count($data_component_source) > 0)
                                                @foreach ($data_component_source as $k=>$v)
                                                    <li data-id="{{$v->id}}" data-value="{{$v->id}}">
                                                        <a href="#">{{$v->name}}</a></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                 
                </div>
            </div>
            <!-- //tab-global-2 -->

            <div role="tabpanel" class="tab-pane" id="tab-global-3">
                <div class="wrapp-global-redesign">
                    <div class="col-md-4">
                        <div class="content-global-redesign">
                            <div class="title-global-redesign">オンライン</div>
                            <div class="img-global-redesign">
                                <center>
                                    <img src="images/phone.jpg" class="img-responsive" alt="">
                                </center>
                            </div>
                            <div class="btn-global-redesign">
                                <a href="" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn-gb-rd">
                                    顧客管理
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="content-global-redesign">
                            <div class="title-global-redesign">フォトギャラリー</div>
                            <div class="img-global-redesign">
                                <center>
                                    <img src="images/phone.jpg" class="img-responsive" alt="">
                                </center>
                            </div>
                            <div class="btn-global-redesign">
                                <a href="" data-toggle="modal" data-target=".bs-example-modal-lg" class="btn-gb-rd">
                                    顧客管理
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //tab-global-3 -->

            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-global-redesign-2" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">フォトギャラリー</h4>
                        </div>

                        <div class="modal-body">
                            <div class="tab-header-gb">
                                <ul class="nav nav-tabs tabs-center">
                                    <li class="active">
                                        <a href="#tab-gb-re-1" aria-controls="tab-gb-re-1" role="tab" data-toggle="tab">
                                            フォトギャラリー
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab-gb-re-2" data-toggle="tab">アカウント設定</a>
                                    </li>
                                </ul>   
                            </div>                   

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tab-gb-re-1">
                                   <div class="wrapp-form-tab-gb-1">
                                       <form>
                                            <label>フォントタイプ・フォントファミリ</label>
                                            <div class="content-tab-3-select-2">
                                                <label for="">1 項目</label>
                                                <select name="" id="" class="form-control middle">
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                </select>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">2 項目</label>
                                                <select name="" id="" class="form-control middle">
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                </select>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">3 項目</label>
                                                <select name="" id="" class="form-control middle">
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                </select>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">4 項目</label>
                                                <select name="" id="" class="form-control middle">
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                </select>
                                            </div>
                                            <div class="content-tab-3-select-2">
                                                <label for="">5 項目</label>
                                                <select name="" id="" class="form-control middle">
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                    <option value="">オンライン</option>
                                                </select>
                                            </div>  
                                            <div class="btn-tab-gb-1">
                                                <a href="">オンライン</a> 
                                            </div>              
                                        </form>
                                   </div>
                                </div>
                                
                                <div role="tabpanel" class="tab-pane" id="tab-gb-re-2">
                                    <div class="wrapp-form-tab-gb-2">
                                        <p>説明が入ります説明が入りまます説明</p>
                                        <p>
                                            が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入り
                                        </p>    
                                        <a href="">顧客管理</a>            
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                    </div>
              </div>
            </div>
            <!-- //modal -->

        <div>
    </section>
</aside>
</form> 
@endsection

@section('footerJS')
    {{Html::script('admin/js/jscolor.js')}}
    <script type="text/javascript">
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