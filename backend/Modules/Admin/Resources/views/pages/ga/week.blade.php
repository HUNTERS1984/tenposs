@extends('admin::layouts.default')

@section('title', 'Google Analytic')

@section('content')
<div class="content">
		<div class="topbar-content">
			<div class="wrap-topbar clearfix">
				<span class="visible-xs visible-sm trigger"><span class="glyphicon glyphicon-align-justify"></span></span>
				<div class="left-topbar">
					<h1 class="title">Google Analytic</h1>
				</div>
			</div>
		</div>
		<!-- END -->

		<div class="main-content ga">
			<div id="curve_chart" style="width: 800px; height: 500px"></div>
		</div>
		<!-- END -->
	</div>	<!-- end main-content-->
@stop

@section('script')
	{{Html::script(env('ASSETS_BACKEND').'/js/jquery-1.11.2.min.js')}}
	{{Html::script(env('ASSETS_BACKEND').'/js/bootstrap.min.js')}}

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Visitors', 'PageViews'],
          @foreach($visitor as $val)
          	['{{date_format($val["date"],"d-m")}}', {{$val['visitors']}}, {{$val['pageViews']}}],
          @endforeach
        ]);

        var options = {
          title: 'Visitor and Pageview site',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
@stop
