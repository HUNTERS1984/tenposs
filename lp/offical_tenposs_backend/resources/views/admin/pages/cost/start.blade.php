@extends('admin.layouts.master')

@section('main')
<aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>コスト管理</span>
            <strong>ポイントやコストの管理が可能</strong>
        </div>
        <div class="right">
            <a href="" class="btn-cost-bre">収益の支払い申請</a>
        </div>
    </div>
    <section class="content">
        <div class="content-cost">
            <img src="images/logo-cost.png" alt="">
            <p>
                tenpossでポイント管理やコスト管理を行う場合は、<br>
                ポイントシステムPOMの登録が必須となります。
            </p>
            
            <a href="{{ route('admin.cost.register') }}">登録する</a>
            
        </div>
    </section>
</aside>
@endsection

@section('footerJS')
<script type="text/javascript">
  
</script>
@endsection