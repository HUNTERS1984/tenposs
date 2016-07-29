@extends('layouts.default')

@section('title', 'Global')

@section('content')
	<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<div class="left-topbar">
					<h1 class="title">Global</h1>
				</div>
				<div class="right-topbar">
					<a href="#" class="btn-me btn-topbar">スタの新</a>
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
								<li><a href="#" alt="tab1" class="active">Tab 1</a></li>
								<li><a href="#" alt="tab2">Tab 2</a></li>
								<li><a href="#" alt="tab3">Tab 3</a></li>
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
					                                    <img class="img-circle" src="{{asset(env('PATH_ASSETS'))}}/images/icon-user.png" height="35" width="35" alt="Thư kỳ"/>
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
								<form action="" class="formCommon">
									<div class="form-group">
										<label for="">スタの新</label>
										<input type="text" name="" class="first-input">
									</div>
									<div class="form-group">
										<label for="">スタの新</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('PATH_ASSETS'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
									<div class="form-group">
										<label for="">スタの新</label>
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
										<label for="">スタの新</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('PATH_ASSETS'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
									<div class="form-group">
										<label for="">スタの新</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('PATH_ASSETS'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>

								</form>
							</div> <!-- end content global -->

							<div class="content-global" id="tab2">
								<form action="" class="formCommon">
									<div class="form-group">
										<label for="">スタの新</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('PATH_ASSETS'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
									<div class="form-group">
										<label for="">スタの新</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('PATH_ASSETS'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
									<div class="form-group">
										<label for="">スタの新</label>
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
										<label for="">スタの新 スタの新</label>
										<div class="wrap-table">
											<div class="wrap-transfer col">
												<p class="title-form">スタの新</p>
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
												<p class="title-form">スタの新</p>
												<ul class="nav-right to-nav">
												</ul>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="content-global" id="tab3">
								<form action="" class="formCommon">
									<div class="form-group">
										<label for="">スタの新</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('PATH_ASSETS'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
									<div class="form-group">
										<label for="">スタの新</label>
										<span><input class="jscolor" value="#ffffff"><img src="{{asset(env('PATH_ASSETS'))}}/images/draw.jpg" height="21" width="20" class="draw" ></span>
									</div>
								</form>
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
	{{Html::script(env('PATH_ASSETS').'/js/jquery-1.11.2.min.js')}}
	{{Html::script(env('PATH_ASSETS').'/js/bootstrap.min.js')}}
	{{Html::script(env('PATH_ASSETS').'/js/jscolor.js')}}
	{{Html::script(env('PATH_ASSETS').'/js/script.js')}}

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