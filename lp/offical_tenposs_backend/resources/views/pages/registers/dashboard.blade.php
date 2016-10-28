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
						      	<p>
						      			TENPOSSへようこそ！ショップ開設ありがとうございます。
この画面ではショップをオープンするまでの道のりを案内したり、商品が売れた通知やTENPOSSからのキャンペーンのお知らせ、上手にショップを運営するためのヒント等を表示します。
まずはショップの公開まで進めてみましょう！
						      	</p>
						       	<p class="text-center">
					       			<button onClick="window.location.reload()" class="btn btn-primary" >閉じる</button>
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
					                    <label for="inputEmail3" class="col-sm-3 control-label">会社名</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="company" name="company" value=""
					                               placeholder="ここのために入力し...">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">事業の種類</label>
					                    <div class="col-sm-9">
					                        <select name="business_type" class="form-control">
					                            <option value="">選択します</option>
					                            <option value="business" >ビジネス</option>
					                            <option value="other" >他の</option>
					                        </select>
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">アプリ名</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="app_name_register" name="app_name_register"  
					                        value=""
					                               placeholder="ここのために入力し...">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">ドメインタイプ</label>
					                    <div class="col-sm-9">
					                        <select name="domain_type" class="form-control">
					                            <option value="">選択します</option>
					                            <option value="od" >ドメインの所有者</option>
					                            <option value="sd" >tenpossのサブドメイン</option>
					                        </select>
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">ドメイン</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="domain" name="domain" value=""
					                               placeholder="ここのために入力し...">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">電話番号</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="tel" name="tel" value=""
					                               placeholder="ここのために入力し...">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">ファックス</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="fax" name="fax" value=""
					                               placeholder="ここのために入力し...">
					                    </div>
					                </div>
					                <p class="text-center">
					                	<button type="submit" class="btn btn-primary"> 登録 </button>
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
					                    <label for="" class="col-sm-3 control-label">ショップへのリンク</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="shop_info" name="shop_info"  value=""
					                               placeholder="">
					                        <label for="" class="text-muted">http://beauty.hotpepper.jp/slnH000196113/</label>       
					                    	 <div id="crawled-info"></div>
					                    </div>
					                   
					                </div>
						      		<p class="text-center">
					                	<button type="submit" class="btn btn-primary"> 完了 </button>
					                </p>
						      	</form>
						      </div>
						    </div>
						</div>
						  @endif
					</div>	
					
					@if ($visibleStepFinal)
					<div class="alert alert-info">
						<div class="text-center">
							<p>この度はTenpossをお申し込みいただき、ありがとうございます。</p>
							<p>&nbsp;</p>
							<p>現時点ではまだお申し込み手続きが完了しておりませんので、管理者から確認する必要があります。</p>
							<p>&nbsp;</p>
							<p>確認にかかる時間は1日以内です</p>
						</div>
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
			$('#shop_info').on('keyup',function(){
				$.ajax({
					url: '{{ route("user.getshopinfo") }}',
					//dataType: 'json',
					data: { url : $(this).val() },
					headers: {
						 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function(response){
						console.log(response);
						$('#crawled-info').html(response);
					}
				});
			})
		})
	</script>
	
@stop