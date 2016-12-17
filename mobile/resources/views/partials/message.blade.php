@if (Session::has('message'))
    <div class="alert {{ Session::get('message.class') }}">
        {{ Session::get('message.detail') }}
    </div>
@endif
@if (count($errors) > 0)
<div id="modal-message" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">お知らせ</h4>
            </div>
            <div class="modal-body">
                <ul style="list-style-type:none;padding: 0px;">
                    @foreach ($errors->all() as $error)
                    <li class="modal-text">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default model-close" data-dismiss="modal">閉じる</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endif