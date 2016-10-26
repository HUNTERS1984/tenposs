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
								<li class="active"><a href="#">プライバシーポリシー</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="page-banner" id="agree">
					<div class="is-table-cell">
						<h1 class="title-page">Privacy Policy</h1>
						<p class="sub-title-page">-　プライバシーポリシー　-</p>
					</div>
				</div>
			</div>
			<!-- END STATIC BANNER -->

			<div class="section search-section">
				<h2 class="title-section">tenposs プライバシーポリシー</h2>
				
				<div class="container">
					@include('layouts.messages')
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						  <div class="panel {{ $step['step1']['status'] }}">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title">
						        <a role="button" 
						        data-toggle="collapse" 
						        data-parent="#accordion" 
						        href="#collapseOne" 
						        aria-expanded="false" 
						        aria-controls="collapseOne">
						          Welcome to Tenpo
						        </a>
						      </h4>
						    </div>
						    <div id="collapseOne" class="panel-collapse collapse {{ $step['step1']['active'] }}" role="tabpanel" aria-labelledby="headingOne">
						      <div class="panel-body">
						       	Welcome
						      </div>
						    </div>
						  </div>
						  
						  <div class="panel {{ $step['step2']['status'] }}">
						    <div class="panel-heading" role="tab" id="headingTwo">
						      <h4 class="panel-title">
						        <a class="collapsed" 
						        role="button" 
						        data-toggle="collapse" 
						        data-parent="#accordion" 
						        href="#collapseTwo" 
						        aria-expanded="false" 
						        aria-controls="collapseTwo">
						          Email verified
						        </a>
						      </h4>
						    </div>
						    <div id="collapseTwo" class="panel-collapse collapse {{ $step['step2']['active'] }}" role="tabpanel" aria-labelledby="headingTwo">
						      <div class="panel-body">
						       <p class="text-center">Verified</p>
						      </div>
						    </div>
						  </div>
						  
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
						          Register product
						        </a>
						      </h4>
						    </div>
						    <div id="collapseThree" class="panel-collapse collapse {{ $step['step3']['active'] }}" role="tabpanel" aria-labelledby="headingThree">
						      <div class="panel-body">
						      	
						       	<form class="form-horizontal form" method="post" action="{{ route('user.register.product.post') }}">
						       		<input type="hidden" name="_token" value="{{ csrf_token() }}" >
						       		<div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">会社名</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="company" name="company" value="{{ Auth::user()->company }}"
					                               placeholder="ここのために入力し...">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">事業の種類</label>
					                    <div class="col-sm-9">
					                        <select name="business_type" class="form-control">
					                            <option value="">選択します</option>
					                            <option value="business" {{ ( Auth::user()->business_type == 'business' ) ? 'selected' : '' }}>ビジネス</option>
					                            <option value="other" {{ ( Auth::user()->business_type == 'other' ) ? 'selected' : '' }}>他の</option>
					                        </select>
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">アプリ名</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="app_name_register" name="app_name_register"  
					                        value="{{ Auth::user()->app_name_register }}"
					                               placeholder="ここのために入力し...">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">ドメインタイプ</label>
					                    <div class="col-sm-9">
					                        <select name="domain_type" class="form-control">
					                            <option value="">選択します</option>
					                            <option value="od" {{ ( Auth::user()->domain_type == 'od' ) ? 'selected' : '' }}>ドメインの所有者</option>
					                            <option value="sd" {{ ( Auth::user()->domain_type == 'sd' ) ? 'selected' : '' }}>tenpossのサブドメイン</option>
					                        </select>
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">ドメイン</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="domain" name="domain" value="{{ Auth::user()->domain }}"
					                               placeholder="ここのために入力し...">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">電話番号</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="tel" name="tel" value="{{ Auth::user()->tel }}"
					                               placeholder="ここのために入力し...">
					                    </div>
					                </div>
					                <div class="form-group">
					                    <label for="inputEmail3" class="col-sm-3 control-label">ファックス</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="fax" name="fax" value="{{ Auth::user()->fax }}"
					                               placeholder="ここのために入力し...">
					                    </div>
					                </div>
					                <p class="text-center">
					                	<button type="submit" class="btn btn-primary"> Send </button>
					                </p>
					                
						       	</form>
						      </div>
						    </div>
						  </div>
						  
						  <div class="panel {{ $step['step4']['status'] }}">
						    <div class="panel-heading" role="tab" id="headingFour">
						      <h4 class="panel-title">
						        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseTwo">
						          Shop info
						        </a>
						      </h4>
						    </div>
						    <div id="collapseFour" class="panel-collapse collapse {{ $step['step4']['active'] }}" role="tabpanel" aria-labelledby="headingFour">
						      <div class="panel-body">
						      	<form class="form-horizontal form" method="post" action="{{ route('user.register.product.post') }}">
						      		<input type="hidden" name="_token" value="{{ csrf_token() }}" >
						      		<div class="form-group">
					                    <label for="" class="col-sm-3 control-label">ショップへのリンク</label>
					                    <div class="col-sm-9">
					                        <input type="text" class="form-control" id="shop_info" name="shop_info"  value="{{ Auth::user()->shop_info }}"
					                               placeholder="">
					                        <label for="" class="text-muted">http://beauty.hotpepper.jp/slnH000196113/</label>       
					                    	 <div id="crawled-info"></div>
					                    </div>
					                   
					                </div>
						      		<p class="text-center">
					                	<button type="submit" class="btn btn-primary"> Finish </button>
					                </p>
						      	</form>
						      </div>
						    </div>
						</div>
					</div>	
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