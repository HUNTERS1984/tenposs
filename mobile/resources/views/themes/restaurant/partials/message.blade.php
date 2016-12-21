@if (count($errors) > 0)
<div data-role="popup" id="windown-message" data-theme="a" class="ui-corner-all modal-pink">    
    <div style="padding:10px 20px;">
        <figure>
            <img src="{{ Theme::asset('img/icon_reject.png') }}" alt="news_big">
        </figure>
        <h3></h3>
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
                <button type="button" class="ui-btn ui-corner-all ui-shadow ui-btn-b">OK</button>
            </div>    
</div>
<a id="open-windown-message" href="#windown-message" data-rel="popup" data-position-to="window" class="select-code" data-transition="pop">
@endif
