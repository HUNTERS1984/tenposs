@extends('admin.layouts.master')

@section('main')
<aside class="right-side"> 
    <div class="wrapp-breadcrumds">
        <div class="left"><span>お問い合わせ</span></div>
    </div>
  
    <section class="content">
        <div class="contact_content">
          <h2>お気軽にお問い合わせ下さい。</h2>
            @include('admin.layouts.messages')
            {{Form::open(array('route'=>'admin.client.contact'))}}
            <div class="form-group">
                {{Form::text('name',old('name'),['class'=>'form-control', 'placeholder' => '何について'])}}
            </div>
            <div class="form-group">
                {{Form::textarea('message',old('message'),['class'=>'form-control', 'rows' => '5', 'placeholder' => '詳しくお聞かせください' ,'style' => 'resize: none;'])}}
            </div>
            <center>{{Form::button('送信',['class'=>'btn btn-contact', 'type' => 'submit'])}}</center>
            
            {{Form::close()}}
        </div>
    </section>
</aside>

@endsection    

@section('footerJS')
    
@endsection