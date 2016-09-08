@extends('admin::layouts.default')

@section('title', 'グローバル')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">グローバル</h1>
				</div>
				<div class="right-topbar">
					<a href="#" class="btn-me btn-topbar">保存</a>
				</div>
			</div>
		</div>
		<!-- END -->

		<div class="main-content global">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12">
						<div class="global-tab">
							<ul class="nav-tab clearfix">
								<li><a href="#" alt="tab1" class="active">ヘッダー</a></li>
								<li><a href="#" alt="tab2">サイトメニュー</a></li>
								<li><a href="#" alt="tab3">Appストア</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="wrap-preview">
							<div class="wrap-content-prview">
								<div class="content-preview clearfix">
									<div class="sidebar-preview">
										<div class="side">
					                        <div class="h_side">
					                            <div class="imageleft">
					                                <div class="image">
					                                    <img class="img-circle" src="{{asset(env('ASSETS_BACKEND'))}}/images/icon-user.png" height="35" width="35" alt="Thư kỳ"/>
					                                </div>
					                                <p class="font32">User name</p>
					                            </div>
					                        </div>
					                        <ul class="s_nav">
					                            <li class="s_icon-home active"><a  href="javascript:avoid();">Home</a></li>
					                            <li class="s_icon-menu"><a href="javascript:avoid();">Menu</a></li>
					                            <li class="s_icon-reserve"><a href="javascript:avoid();">Reserve</a></li>
					                            <li class="s_icon-news"><a href="javascript:avoid();">News</a></li>
					                            <li class="s_icon-photo"><a href="javascript:avoid();">Photo Gallery</a></li>
					                            <li class="s_icon-staff"><a href="javascript:avoid();">Staff</a></li>
					                            <li class="s_icon-coupon"><a href="javascript:avoid();">Coupon</a></li>
					                            <li class="s_icon-chat"><a href="javascript:avoid();">Chat</a></li>
					                            <li class="s_icon-setting"><a href="javascript:avoid();">Setting</a></li>
					                        </ul>
					                    </div><!-- End side -->
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="wrapper-content">
							<div class="content-global" id="tab1">
								{{Form::open(array('route'=>'admin.menus.store', 'class' => 'formCommon'))}}
									<div class="form-group">
										<label for="">タイトル</label>
										<input type="text" name="" class="first-input">
									</div>
									<div class="form-group">
										<label for="">タイトルカラー</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
									<div class="form-group">
										<label for="">フォントタイプ・フォントファミリ</label>
										<span class="inline">
											<select name="fontsize" class="font-size">
												<option value="12">12px</option>
												<option value="14">14px</option>
											</select>
											<select name="type" id="">
												<option value="">スタの新スタの新</option>
											</select>
										</span>
									</div>
									<div class="form-group">
										<label for="">ヘッダーカラー</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
									<div class="form-group">
										<label for="">メニューイコンカラー</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>

								{{Form::close()}}
							</div> <!-- end content global -->

							<div class="content-global" id="tab2">
								{{Form::open(array('route'=>'admin.menus.store', 'class' => 'formCommon'))}}
									<div class="form-group">
										<label for="">バックグラウンドカラー</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
									<div class="form-group">
										<label for="">フォントカラー</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
									<div class="form-group">
										<label for="">フォントタイプ・フォントファミリ</label>
										<span class="inline">
											<select name="fontsize" class="font-size">
												<option value="12">12px</option>
												<option value="14">14px</option>
											</select>
											<select name="type" id="">
												<option value="">スタの新スタの新</option>
											</select>
										</span>
									</div>
									<div class="form-group clearfix">
										<label for="">サイトメニュー項目</label>
										<div class="wrap-table">
											<div class="wrap-transfer col">
												<p class="title-form">表示</p>
												<ul class="nav-left from-nav">
													<li>TEST 1</li>
													<li>TEST 2</li>
													<li>TEST 3</li>
												</ul>
											</div>
											<div class="wrap-btn-control col">
												<a href="javascript:moveTo('from-nav','to-nav')" ><span class="glyphicon glyphicon-triangle-right"></span></a>
												<a href="javascript:moveTo('to-nav','from-nav')" ><span class="glyphicon glyphicon-triangle-left"></span></a>
											</div>
											<div class="wrap-transfer col">
												<p class="title-form">非表示</p>
												<ul class="nav-right to-nav">
												</ul>
											</div>
										</div>
									</div>
								{{Form::close()}}
							</div>
							<div class="content-global" id="tab3">
								{{Form::open(array('route'=>'admin.menus.store', 'class' => 'formCommon'))}}
									<div class="form-group">
										<label for="">アプリアイコン</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
									<div class="form-group">
										<label for="">Store用画像</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('ASSETS_BACKEND'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
								</form>
								{{Form::close()}}
							</div>
						</div>	<!-- wrap-content-->
					</div>
				</div>
			</div>
			
		</div>
		<!-- END -->
	</div>	<!-- end main-content-->

@stop

@section('script')
	{{Html::script(env('ASSETS_BACKEND').'/js/jquery-1.11.2.min.js')}}
	{{Html::script(env('ASSETS_BACKEND').'/js/bootstrap.min.js')}}
	{{Html::script(env('ASSETS_BACKEND').'/js/jscolor.js')}}
	{{Html::script(env('ASSETS_BACKEND').'/js/script.js')}}

	<script type="text/javascript">
		$(document).ready(function(){
			$('.content-global').not(':first').hide();

			$('.nav-tab li a').on('click',function(e){
				e.preventDefault();
				var id = $(this).attr('alt');
				$('.nav-tab li a').removeClass('active');
				$('.content-global').slideUp();
				$(this).addClass('active');
				$('#'+id).slideDown();
			})

			$('.nav-left, .nav-right').on('click','li',function(){
				$(this).toggleClass('selected');
			});
		})
		function moveTo(from,to){
			$('ul.'+from+' li.selected').remove().appendTo('ul.'+to);
			$('.'+to+' li').removeAttr('class');
		}
	</script>



@stop