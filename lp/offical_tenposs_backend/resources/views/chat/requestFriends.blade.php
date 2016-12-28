<div style="text-align: center">
    {!! $bot->add_friend_href !!}
    <p>OR</p>
    <div width="100%" class="QRimage">
     {!! $bot->qr_code_href !!}
    </div>
</div>
<style>
.QRimage img {
	width: 100%;
}
</style>