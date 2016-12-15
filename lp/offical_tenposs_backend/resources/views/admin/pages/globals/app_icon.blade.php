<div class="modal-dialog modal-global-redesign" role="document">
    <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">アプリアイコン作成依頼</h4>
        </div>

        <div class="modal-body">

            <div class="left-global-redesign">
                <div class="title-left-global-redesign">
                    <span>ロゴの種類を選択</span>
                </div>
                <ul>
                    <li class="active">
                        <a href="#app-icon-type-1" data-toggle="tab">
                            <img src="images/nav-global-redesign.jpg" alt="">
                            <span>Type 1</span>
                        </a>
                    </li>

                    <li>
                        <a href="#app-icon-type-2" data-toggle="tab">
                            <img src="images/nav-global-redesign.jpg" alt="">
                            <span>Type 2</span>
                        </a>
                    </li>
                    <li>
                        <a href="#app-icon-type-3" data-toggle="tab">
                            <img src="images/nav-global-redesign.jpg" alt="">
                            <span>Type 3</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="right-global-redesign tab-content">
                <div id="app-icon-type-1" class="tab-pane active">
                    <form id="" action="">
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <label>画像アップロード</label>
                                <div class="wrapp-draw">
                                    <input type="file" id="app-ico-image" name="app_ico_image" class="hidden"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>ロゴのタイトル</label>
                                <input name="app_ico_title" type="text" class="form-control " id="app-ico-title" placeholder="タイトル">
                            </div>
                            <div class="form-group">
                                <label>タイトルカラー</label>
                                <div class="global-wrapp-draw">
                                    <input  name="app_ico_title_color" id="app-ico-title-color" type="text" class="form-control middle jscolor {onFineChange:'change_app_ico_title_color(this)'}" placeholder="000000">
                                    <img onclick="document.getElementById('app-ico-title-color').jscolor.show()"
                                         src="/assets/backend/images/draw.jpg"
                                         class="left">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>背景カラー</label>
                                <div class="global-wrapp-draw">
                                    <input name="app_ico_bg_color" id="app-ico-bg-color" type="text" class="form-control middle jscolor {onFineChange:'change_app_ico_bg_color(this)'}" placeholder="000000">
                                    <img onclick="document.getElementById('app-ico-bg-color').jscolor.show()"
                                         src="/assets/backend/images/draw.jpg"
                                         class="left">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-xs-12">
                            <div class="row">
                                <div class="content-right-gl-rd">
                                    <div class="pixel-title">256px x 256px</div>
                                    <div id="app-ico-canvas-holder" class="app-logo-review box-256px">
                                        <p class="app_logo_title">ICO TITLE</p>
                                        <img class="app_logo_review" src="/admin/images/logo-m.png" alt=""/>
                                    </div>

                                    <div class="box-bottom-gl-re">
                                        <ul class="box-px">
                                            <li>
                                                <div class="pixel-title">
                                                    120px x 120px
                                                </div>
                                                <div class="app-logo-review box-120px">
                                                    <p class="app_logo_title">ICO TITLE</p>
                                                    <img class="app_logo_review" src="/admin/images/logo-m.png" alt=""/>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="pixel-title">
                                                    80px x 80px
                                                </div>
                                                <div class="app-logo-review box-80px">
                                                    <p class="app_logo_title">ICO TITLE</p>
                                                    <img class="app_logo_review" src="/admin/images/logo-m.png" alt=""/>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="pixel-title">
                                                    60px x 60px
                                                </div>
                                                <div class="app-logo-review box-60px">
                                                    <p class="app_logo_title">ICO TITLE</p>
                                                    <img class="app_logo_review" src="/admin/images/logo-m.png" alt=""/>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <div class="col-md-3">
                                <a id="convert-to-canvas" href="#" class="btn-box-px">作成依頼</a>
                                <div class="hidden" id="app-ico-canvas"></div>
                                <p>&nbsp;</p>
                                </div>
                                <div class="col-md-3">
                                <p id="response-msg-type1" class="text-center"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="app-icon-type-2" class="tab-pane">
                    <form id="" action="">
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <label>ロゴのタイトル</label>
                                <input name="app_ico_title_type2" type="text" class="form-control " id="app-ico-title-type2" placeholder="タイトル">
                            </div>
                            <div class="form-group">
                                <label>タイトルカラー</label>
                                <div class="global-wrapp-draw">
                                    <input  name="app_ico_title_color_type2" id="app-ico-title-color-type2" type="text" class="form-control middle jscolor {onFineChange:'change_app_ico_title_color_type2(this)'}" placeholder="000000">
                                    <img onclick="document.getElementById('app-ico-title-color-type2').jscolor.show()"
                                         src="/assets/backend/images/draw.jpg"
                                         class="left">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>背景カラー</label>
                                <div class="global-wrapp-draw">
                                    <input name="app_ico_bg_color_type2" id="app-ico-bg-color-type2" type="text" class="form-control middle jscolor {onFineChange:'change_app_ico_bg_color_type2(this)'}" placeholder="000000">
                                    <img onclick="document.getElementById('app-ico-bg-color-type2').jscolor.show()"
                                         src="/assets/backend/images/draw.jpg"
                                         class="left">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-xs-12">
                            <div class="row">
                                <div class="content-right-gl-rd">
                                    <div class="pixel-title">256px x 256px</div>
                                    <div id="app-ico-canvas-holder-type2" class="app-ico-canvas-holder-type2">
                                        <div class="app-ico-review-type2-256px">
                                            <div class="type2-border-left"></div>
                                            <div class="type2-border-top"></div>
                                            <p class="app_logo_title_type2">ICOTITLE</p>
                                        </div>
                                    </div>
                                    <div class="box-bottom-gl-re">
                                        <ul class="box-px clearfix" style="padding: 0">
                                            <li>
                                                <div class="pixel-title">
                                                    120px x 120px
                                                </div>
                                                <div id="" class="app-ico-canvas-holder-type2">
                                                    <div class="app-ico-review-type2-120px">
                                                        <div class="type2-border-left"></div>
                                                        <div class="type2-border-top"></div>
                                                        <p class="app_logo_title_type2">ICOTITLE</p>
                                                    </div>
                                                </div>


                                            </li>
                                            <li>
                                                <div class="pixel-title">
                                                    80px x 80px
                                                </div>
                                                <div id="" class="app-ico-canvas-holder-type2">
                                                    <div class="app-ico-review-type2-80px">
                                                        <div class="type2-border-left"></div>
                                                        <div class="type2-border-top"></div>
                                                        <p class="app_logo_title_type2">ICOTITLE</p>
                                                    </div>
                                                </div>

                                            </li>
                                            <li>
                                                <div class="pixel-title">
                                                    60px x 60px
                                                </div>
                                                <div id="" class="app-ico-canvas-holder-type2">
                                                    <div class="app-ico-review-type2-60px">
                                                        <div class="type2-border-left"></div>
                                                        <div class="type2-border-top"></div>
                                                        <p class="app_logo_title_type2">ICOTITLE</p>
                                                    </div>
                                                </div>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <div class="col-md-3">
                                <a id="convert-to-canvas-type2" href="#" class="btn-box-px">作成依頼</a>
                                <div class="hidden" id="app-ico-canvas-type2"></div>
                                <p>&nbsp;</p>
                                </div>
                                <div class="col-md-3">
                                <p id="response-msg-type2" class="text-center"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="app-icon-type-3" class="tab-pane">
                    <form id="" action="">
                        <div class="col-md-5 col-xs-12">
                            <div class="form-group">
                                <label>画像アップロード</label>
                                <div class="wrapp-draw">
                                    <input type="file" id="app-ico-file-type3" name="app_ico_file_type3" class="hidden"/>
                                </div>

                            </div>
                            <div class="form-group">
                                <label>背景カラー1</label>
                                <div class="global-wrapp-draw">
                                    <input  name="app_ico_back_color_type3" id="app-ico-back-color-type3" type="text" class="form-control middle jscolor {onFineChange:'change_app_ico_back_color_type3(this)'}" placeholder="000000">
                                    <img onclick="document.getElementById('app-ico-back-color-type3').jscolor.show()"
                                         src="/assets/backend/images/draw.jpg"
                                         class="left">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>背景カラー2</label>
                                <div class="global-wrapp-draw">
                                    <input name="app_ico_bg_color_type3" id="app-ico-bg-color-type3" type="text" class="form-control middle jscolor {onFineChange:'change_app_ico_bg_color_type3(this)'}" placeholder="000000">
                                    <img onclick="document.getElementById('app-ico-bg-color-type3').jscolor.show()"
                                         src="/assets/backend/images/draw.jpg"
                                         class="left">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Scale</label>
                                <div class="global-wrapp-draw">
                                    <input id="app_ico_image_scale" name="app_ico_image_scale" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="50"/>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-7 col-xs-12">
                            <div class="row">
                                <div class="content-right-gl-rd">
                                    <div class="pixel-title">256px x 256px</div>
                                    <div id="app-ico-canvas-holder-type3" class="app-ico-canvas-holder-type3">
                                        <div class="app-ico-review-type3-256px">
                                            <div class="type3-border-left"></div>
                                            <div class="type3-border-top"></div>
                                            <img class="app_logo_file_type3" src="/admin/images/logo-m.png" alt=""/>
                                        </div>
                                    </div>
                                    <div class="box-bottom-gl-re">
                                        <ul class="box-px clearfix" style="padding: 0">
                                            <li>
                                                <div class="pixel-title">
                                                    120px x 120px
                                                </div>
                                                <div id="" class="app-ico-canvas-holder-type3">
                                                    <div class="app-ico-review-type3-120px">
                                                        <div class="type3-border-left"></div>
                                                        <div class="type3-border-top"></div>
                                                        <img class="app_logo_file_type3" src="/admin/images/logo-m.png" alt=""/>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="pixel-title">
                                                    80px x 80px
                                                </div>
                                                <div id="" class="app-ico-canvas-holder-type3">
                                                    <div class="app-ico-review-type3-80px">
                                                        <div class="type3-border-left"></div>
                                                        <div class="type3-border-top"></div>
                                                        <img class="app_logo_file_type3" src="/admin/images/logo-m.png" alt=""/>
                                                    </div>
                                                </div>

                                            </li>
                                            <li>
                                                <div class="pixel-title">
                                                    60px x 60px
                                                </div>
                                                <div id="" class="app-ico-canvas-holder-type3">
                                                    <div class="app-ico-review-type3-60px">
                                                        <div class="type3-border-left"></div>
                                                        <div class="type3-border-top"></div>
                                                        <img class="app_logo_file_type3" src="/admin/images/logo-m.png" alt=""/>
                                                    </div>
                                                </div>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <div class="col-md-3">
                                <a id="convert-to-canvas-type3" href="#" class="btn-box-px">作成依頼</a>
                                <div class="hidden" id="app-ico-canvas-type3"></div>
                                <p>&nbsp;</p>
                                </div>
                                <div class="col-md-3">
                                <p id="response-msg-type3" class="text-center"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>


        </div>
    </div>
</div>