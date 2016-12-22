@if (count($errors) > 0)
<div data-role="popup" data-position-to="window" id="windown-message" data-theme="a" class="ui-corner-all modal-pink" data-transition="flip">
    <div style="padding:10px 20px;">
        <figure>
            <img src="{{ Theme::asset('img/icon_reject.png') }}" alt="news_big">
        </figure>
        <h3>通知します</h3>
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
         <a href="#" 
         data-rel="back" 
         data-role="button" 
         data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn ui-corner-all ui-shadow ui-btn-b">Close</a>
    </div>    
</div>
@endif



