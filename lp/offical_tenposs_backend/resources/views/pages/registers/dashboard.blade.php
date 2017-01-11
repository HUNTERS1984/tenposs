@extends('layouts.default')

@section('title','Agree')

@section('css')
	{{Html::style(asset('assets/frontend').'/css/agree.css')}}
@stop



@section('content')
	<div class="middle page">
			<div class="static-banner">
				<div class="breadcrum">
					<div class="container">
						<div class="row">
							<ul class="breadcrum-me">
								<li><a href="javascript:avoid()">Top</a></li>
								<li class="active"><a href="#">ユーザーダッシュボード</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-banner" id="agree">
					<div class="is-table-cell">
						<h1 class="title-page">User Dashboard</h1>
						<p class="sub-title-page">ユーザーダッシュボード</p>
					</div>
				</div>
			</div>
			<!-- END STATIC BANNER -->

			<div class="section search-section">
				
				<div class="container">
					@include('layouts.messages')
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						@if( $visibleStep1 )
						  <div class="panel {{ $step['step1']['status'] }}">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title">
						        <a class="collapsed" 
						        role="button" 
						        data-toggle="collapse" 
						        data-parent="#accordion" 
						        href="#collapseOne" 
						        aria-expanded="false" 
						        aria-controls="collapseOne">
						          TENPOSSへようこそ
						        </a>
						      </h4>
						    </div>
						    <div id="collapseOne" class="panel-collapse collapse {{ $step['step1']['active'] }}" role="tabpanel" aria-labelledby="headingOne">
						      <div class="panel-body">
						      	<p style="padding:30px">
						      			Tenpossへようこそ！
app作成アカウントの開設有難うございます。この管理画面ではアプリ登録までのステップを案内したり、クーポンを利用されたユーザーの通知やTenposs からのキャンペーンのお知らせ、上手にアプリを運営するためのヒント等を表示します。 まずはアプリの公開まで進めてみましょう！
						      	</p>
						       	<p class="text-center">
					       			<button onClick="window.location.reload()" class="btn btn-primary btn-xanhduong" >次へ</button>
					       		</p>
						      </div>
						    </div>
						  </div>
						@endif
						  
					<!-- 	  <div class="panel {{ $step['step2']['status'] }}">
						    <div class="panel-heading" role="tab" id="headingTwo">
						      <h4 class="panel-title">
						        <a class="collapsed" 
						        role="button" 
						        data-toggle="collapse" 
						        data-parent="#accordion" 
						        href="#collapseTwo" 
						        aria-expanded="false" 
						        aria-controls="collapseTwo">
						          メール認証をしましょう！
						        </a>
						      </h4>
						    </div>
						    <div id="collapseTwo" class="panel-collapse collapse {{ $step['step2']['active'] }}" role="tabpanel" aria-labelledby="headingTwo">
						      <div class="panel-body">
						       
						        	<p>認証用のURLを記載したメールを送信しておりますので、記載されたURLにアクセスしメール認証を完了してください。 認証用のURLの再送信は、以下のボタンより行ってください。</p>
						       		<p class="text-center">
						       			<a href="#">承認用メールを再送信する</a>
						       		</p>

						      </div>
						    </div>
						  </div> -->
						  @if( $visibleStep3 )
						  <div class="panel {{ $step['step3']['status'] }}">
						    <div class="panel-heading" role="tab" id="headingThree">
						      <h4 class="panel-title">
						        <a class="collapsed" 
						        role="button" 
						        data-toggle="collapse" 
						        data-parent="#accordion" 
						        href="#collapseThree" 
						        aria-expanded="false" 
						        aria-controls="collapseThree">
						          アプリ登録
						        </a>
						      </h4>
						    </div>
						    <div id="collapseThree" class="panel-collapse collapse {{ $step['step3']['active'] }}" role="tabpanel" aria-labelledby="headingThree">
						      <div class="panel-body">
						      	
						       	<form class="form-horizontal form" method="post" action="{{ route('user.dashboard.post') }}">
						       		<input type="hidden" name="_token" value="{{ csrf_token() }}" >
						       		<div class="form-group">
					                    <label for="inputEmail3" class="col-sm-offset-2 col-sm-4">会社名</label>
					                    <div class="col-sm-4">
					                        <input type="text" class="form-control" id="company" name="company" value="{{ old('company') }}"
					                               placeholder="">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-offset-2 col-sm-4">事業形態</label>
					                    <div class="col-sm-4">
					                        <select name="business_type" class="form-control">
					                            <option value="">選択します</option>
			                                    <option value="0" {{ (old('business_type') == '0') ? 'selected' : '' }}>法人</option>
			                                    <option value="1" {{ (old('business_type') == '1') ? 'selected' : '' }}>個人</option>
			                                    <option value="2" {{ (old('business_type') == '2') ? 'selected' : '' }}>その他</option>

					                        </select>
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-offset-2 col-sm-4">アプリ名</label>
					                    <div class="col-sm-4">
					                        <input type="text" class="form-control" id="app_name_register" name="app_name_register"  
					                        value="{{ old('app_name_register') }}"
					                               placeholder="">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-offset-2 col-sm-4">ドメインタイプ</label>
					                    <div class="col-sm-4">
					                        <select name="domain_type" class="form-control">
					                            <option value="">選択します</option>
					                            <option value="main" {{ (old('domain_type') == 'main') ? 'selected' : '' }}>所有者のドメイン (example.com)</option>
					                            <option value="sub" {{ (old('domain_type') == 'sub') ? 'selected' : '' }}>Tenpossのサブドメイン (example.ten-po.com)</option>
					                        </select>
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-offset-2 col-sm-4">ドメイン</label>
					                    <div class="col-sm-4">
					                        <input type="text" class="form-control" id="domain" name="domain" value="{{ old('domain') }}"
					                               placeholder="">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-offset-2 col-sm-4">電話番号</label>
					                    <div class="col-sm-4">
					                        <input type="text" class="form-control" id="tel" name="tel" value="{{ old('tel') }}"
					                               placeholder="">
					                    </div>
					                </div>
<!-- 					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-offset-2 col-sm-4">ファックス</label>
					                    <div class="col-sm-4">
					                        <input type="text" class="form-control" id="fax" name="fax" value="{{ old('fax') }}"
					                               placeholder="">
					                    </div>
					                </div> -->
					                <p class="text-center">
					                	<button type="submit" class="btn btn-primary btn-xanhduong"> 次へ </button>
					                </p>
					                
						       	</form>
						      </div>
						    </div>
						  </div>
						  @endif
						  
						  @if( $visibleStep4 )
						  <div class="panel {{ $step['step4']['status'] }}">
						    <div class="panel-heading" role="tab" id="headingFour">
						      <h4 class="panel-title">
						        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseTwo">
						          ショップ情報
						        </a>
						      </h4>
						    </div>
						    <div id="collapseFour" class="panel-collapse collapse {{ $step['step4']['active'] }}" role="tabpanel" aria-labelledby="headingFour">
						      <div class="panel-body">
						      	<form class="form-horizontal form" method="post" action="{{ route('user.dashboard.post') }}">
						      		<input type="hidden" name="_token" value="{{ csrf_token() }}" >
						      		<div class="form-group">
						      			
					      				<div class="form-group">
						                    <label for="" class="col-sm-offset-2 col-sm-4">ショップURL</label>
						                   	<div class="input-group col-sm-5" style="padding-left:10px">
										      <input type="text" class="form-control" id="shop_info" placeholder="beauty.hotpepper.jpまたはtabelog.comのURL">
										      <span class="input-group-btn">
										        <button type="button" id="btn-fetch" class="btn btn-primary btn-xanhduong">取得!</button>
										      </span>
										    </div>
										    <label id"shop_sample" for="" class="col-sm-offset-6 text-muted" style="padding-left:10px; word-break: break-word;">例えば：http://beauty.hotpepper.jp/slnH000196113/</label>
										   	</div>
					                   	<div id="crawled-info" class="">
								       		<div class="form-group">
							                    <label for="" class="col-sm-offset-2 col-sm-4">ブランド名・店舗名</label>
							                    <div class="col-sm-4">
							                        <input type="text" class="form-control" id="shop_name_register" name="shop_name_register" value="{{ old('shop_name_register') }}"
							                               placeholder="">
							                    </div>
							                </div>
							                <div class="form-group">
							                    <label for="" class="col-sm-offset-2 col-sm-4">カテゴリー</label>
							                    <div class="col-sm-4">
							                        <select name="shop_category"  id="shop_category" class="form-control">
							                            <option value="">選択します</option>
					                                    <option value="0">ファッション</option>
					                                    <option value="1">飲食業界</option>
					                                    <option value="2">美容業界</option>
					                                    <option value="3">情報</option>
					                                    <option value="4">その他</option>

							                        </select>
							                    </div>
							                </div>
							               	<div class="form-group">
							                    <label for="" class="col-sm-offset-2 col-sm-4">お店のホームページ</label>
							                    <div class="col-sm-4">
							                        <input type="text" class="form-control" id="shop_url_register" name="shop_url_register"  
							                        value="{{ old('shop_url_register') }}"
							                               placeholder="">
							                    </div>
							                </div>

							                <div class="form-group">
							                    <label for="" class="col-sm-offset-2 col-sm-4">住所</label>
							                    <div class="col-sm-4">
							                        <input type="text" class="form-control" id="shop_address_register" name="shop_address_register"  
							                        value="{{ old('shop_address_register') }}"
							                               placeholder="">
							                    </div>
							                </div>
							                <div class="form-group">
							                    <label for="" class="col-sm-offset-2 col-sm-4">電話番号</label>
							                    <div class="col-sm-4">
							                        <input type="text" class="form-control" id="shop_tel_register" name="shop_tel_register"  
							                        value="{{ old('shop_tel_register') }}"
							                               placeholder="">
							                    </div>
							                </div>
							               	<div class="form-group">
							                    <label for="" class="col-sm-offset-2 col-sm-4">営業時間(例:AM10:00~PM21:00)</label>
							                    <div class="col-sm-4">
							                        <input type="text" class="form-control" id="shop_time_register" name="shop_time_register"  
							                        value="{{ old('shop_time_register') }}"
							                               placeholder="">
							                    </div>
							                </div>
							                <div class="form-group">
							                    <label for="" class="col-sm-offset-2 col-sm-4">定休日</label>
							                    <div class="col-sm-4">
							                        <input type="text" class="form-control" id="shop_close_register" name="shop_close_register"  
							                        value="{{ old('shop_close_register') }}"
							                               placeholder="">
							                    </div>
							                </div>
								            <div class="form-group">
							                    <label for="" class="col-sm-offset-2 col-sm-4">コメント・紹介文</label>
							                    <div class="col-sm-4">
							                        <textarea type="text" class="form-control" id="shop_description_register" name="shop_description_register"  
							                        value="" placeholder="" rows="3" cols="10">{{old('shop_description_register')}}</textarea>
							                    </div>
							                </div>
								            

					                   	</div>
					                </div>
						      		<p class="text-center">
						      			<button type="submit" class="button-register"> 完了 </button>
					                </p>
						      	</form>
						      </div>
						    </div>
						</div>
						  @endif
					</div>	
					
					@if ($visibleStepFinal)
					<div class="content-welcome">
						<img src="{{ url('assets/frontend/img/logo-agree.jpg') }}" alt="">
						<p class="text-center">
							この度はTenpossをお申し込みいただき、ありがとうございます。<br/><br/>
							現時点ではまだお申し込み手続きが完了しておりません。簡単な審査と確認を行います。 確認にかかるお時間は最大で3営業日になります。よろしくお願いします。
						</p>
					</div>
					@endif
				</div>
			</div>
			<!-- END SEARCH -->

			@include('layouts.contact-section')
		</div>
		<!-- END MIDDLE -->
@stop

@section('script')
	{{Html::script(asset('assets/frontend').'/js/jquery.viewportchecker.min.js')}}
	<script>
		$(document).ready(function(){
			$('#btn-fetch').on('click',function(){
				$.ajax({
					url: '{{ route("user.getshopinfo") }}',
					//dataType: 'json',
					data: { url : $('#shop_info').val() },
					headers: {
						 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(response){
						var obj = jQuery.parseJSON(response);
						console.log(obj);
						$('#shop_tel_register').val(obj['電話番号']);
						$('#shop_close_register').val(obj['定休日']);
						$('#shop_url_register').val(obj['お店のホームページ']);
						$('#shop_time_register').val(obj['営業時間']);
						$('#shop_address_register').val(obj['住所']);
						$('#shop_name_register').val(obj['店舗名']);
						$('#shop_description_register').text(obj['紹介文']);
						$('#shop_category').val(obj['カテゴリー']);
					}
				});
			})
		})
	</script>
	
@stop