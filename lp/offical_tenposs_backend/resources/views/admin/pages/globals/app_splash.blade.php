<div class="modal-dialog modal-global-redesign-2" role="document">
    <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">ストア用スクリーンショット作成依頼</h4>
        </div>

        <div class="modal-body">
            <div class="tab-header-gb">
                <ul class="nav nav-tabs tabs-center">
                    <li class="active">
                        <a href="#tab-gb-re-1" aria-controls="tab-gb-re-1" role="tab" data-toggle="tab">
                            スクリーンショット
                        </a>
                    </li>
                    <li>
                        <a href="#tab-gb-re-2" data-toggle="tab">オリジナル作成</a>
                    </li>
                </ul>
            </div>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab-gb-re-1">
                    <div class="wrapp-form-tab-gb-1">
                        <label>ストア用スクリーンショット</label>
                        <p class="text-danger">File dementions: 750px x 1334px</p>
                        <p id="upload-response"></p>
                        <div class="panel panel-info">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-2 col-md-offset-1">
                                    <div class="text-center">
                                        <label for="">1 枚目</label>
                                        <div class="splash-img" id="splash_image_1">
                                            <?php
                                                $image = ($app_stores->splash_image_1 != '')
                                                    ? url($app_stores->splash_image_1)
                                                    : url('admin/images/no-image.jpg');
                                            ?>
                                            <img id="review-splash-img-1" class="img-responsive" src="{{ $image }}" alt=""/>
                                            <input type="file" class="hidden" data-review="#review-splash-img-1" name="splash_image_1"/>
                                            <p>&nbsp;</p>
                                            @if( $app_stores->splash_image_1 != '' )
                                            <a href="#" data-control="splash_image_1" class="remove-app-splash"></a>
                                            @endif
                                            <button class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <label for="">2 枚目</label>
                                        <div class="splash-img" id="splash_image_2">
                                            <?php
                                            $image = ($app_stores->splash_image_2 != '')
                                                ? url($app_stores->splash_image_2)
                                                : url('admin/images/no-image.jpg');
                                            ?>
                                            <img id="review-splash-img-2" class="img-responsive" src="{{ $image }}" alt=""/>
                                            <input type="file" class="hidden" data-review="#review-splash-img-2" name="splash_image_2"/>
                                            <p>&nbsp;</p>
                                            @if( $app_stores->splash_image_2 != '' )
                                            <a href="#" data-control="splash_image_2" class="remove-app-splash"></a>
                                            @endif
                                            <button class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <label for="">3 枚目</label>
                                        <div class="splash-img" id="splash_image_3">
                                            <?php
                                            $image = ($app_stores->splash_image_3 != '')
                                                ? url($app_stores->splash_image_3)
                                                : url('admin/images/no-image.jpg');
                                            ?>
                                            <img id="review-splash-img-3" class="img-responsive" src="{{ $image }}" alt=""/>
                                            <input type="file" class="hidden" data-review="#review-splash-img-3" name="splash_image_3"/>
                                            <p>&nbsp;</p>
                                            @if( $app_stores->splash_image_3 != '' )
                                            <a href="#" data-control="splash_image_3" class="remove-app-splash"></a>
                                            @endif
                                            <button class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <label for="">4 枚目</label>
                                        <div class="splash-img" id="splash_image_4">
                                            <?php
                                            $image = ($app_stores->splash_image_4 != '')
                                                ? url($app_stores->splash_image_4)
                                                : url('admin/images/no-image.jpg');
                                            ?>
                                            <img id="review-splash-img-4" class="img-responsive" src="{{ $image }}" alt=""/>
                                            <input type="file" class="hidden" data-review="#review-splash-img-4" name="splash_image_4"/>
                                            <p>&nbsp;</p>
                                            @if( $app_stores->splash_image_4 != '' )
                                            <a href="#" data-control="splash_image_4" class="remove-app-splash"></a>
                                            @endif
                                            <button class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <label for="">5 枚目</label>
                                        <div class="splash-img" id="splash_image_5">
                                            <?php
                                            $image = ($app_stores->splash_image_5 != '')
                                                ? url($app_stores->splash_image_5)
                                                : url('admin/images/no-image.jpg');
                                            ?>
                                            <img id="review-splash-img-5" class="img-responsive" src="{{ $image }}" alt=""/>
                                            <input type="file" class="hidden" name="splash_image_5" data-review="#review-splash-img-5"/>
                                            <p>&nbsp;</p>
                                            @if( $app_stores->splash_image_5 != '' )
                                            <a href="#" data-control="splash_image_5" class="remove-app-splash"></a>
                                            @endif
                                            <button class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab-gb-re-2">
                    <div class="wrapp-form-tab-gb-2">
                        <p>説明が入ります説明が入りまます説明</p>
                        <p>
                            が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入り
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>