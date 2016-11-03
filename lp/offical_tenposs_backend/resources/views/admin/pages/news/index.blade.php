@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
    <!-- Modal -->
    <div class="modal fade" id="news-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog-news" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">ニュース追加</h4>
          </div>
          <div class="news-edit">
            <form action="">
                <div class="modal-body">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>ストア</label>
                            <select name="" id="" class="form-control">
                                <option value="">オンライン</option>
                                <option value="">オンライン</option>
                                <option value="">オンライン</option>
                                <option value="">オンライン</option>
                                <option value="">オンライン</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>タイトル</label>
                            <input type="text" class="form-control" id="" placeholder="タイトル">
                        </div>
                        <div class="form-group">
                            <label for="description">説明</label>
                            <textarea class="form-control" placeholder="説明" name="description" cols="50" rows="7" id="description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-5">  
                        <div class="file-preview ">
                            <center>
                                <img src="images/male.png" class="img-responsive" alt="">
                            </center>
                        </div>
                        <div class="file-wrapp">
                            <center>
                                <input type="file" id="filecount" multiple="multiple" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);"><div class="bootstrap-filestyle input-group"><span class="group-span-filestyle " tabindex="0"><label for="filecount" class="btn btn-danger "><span class="glyphicon glyphicon-folder-open"></span> <span class="buttonText">画像アップロード</span></label></span></div>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">削除</button>
                    <button type="button" class="btn btn-primary">保存</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="wrapp-breadcrumds">
        <div class="left"><span>ニュース</span></div>
        <div class="right">
            <span class="switch-button">
                <div class="lcs_wrap">
                    <input type="checkbox" name="check-1" value="4" class="lcs_check" autocomplete="disable">
                    <div class="lcs_switch  lcs_checkbox_switch lcs_off">
                        <div class="lcs_cursor"></div>
                        <div class="lcs_label lcs_label_on">表示項</div>
                        <div class="lcs_label lcs_label_off">表示項</div>
                    </div>
                </div>
            </span>
            <a href="" data-toggle="modal" data-target="#news-add" class="btn-2">ポ覧</a>
        </div>
    </div>
    <section class="content">
        <div class="col-md-4">
            <div class="wrapp-phone">
                <center>
                    <img src="images/phone.jpg" class="img-responsive" alt="">
                </center>
            </div>
        </div>
        <div class="col-md-8">
            <div class="btn-menu">
                <a href="" class="btn-3">
                    <i class="glyphicon glyphicon-plus"></i> 項目追加
                </a>
                <a href="" class="btn-4">
                    <i class="glyphicon glyphicon-plus"></i> メニュー追加
                </a>
            </div>
            <div class="wrapp-news">
                <div class="news-content">
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <a href="news-edit.html">
                                <center>
                                    <img src="images/img-news.jpg" class="img-responsive" alt="">
                                </center>
                            </a>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <div class="title-news">
                                <div class="row">
                                    <div class="col-md-8 col-xs-12">
                                        <a href="news-edit.html" class="text-news-left">ュー追加</a>
                                        <p>クポン覧クポン</p>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <a href="" class="btn-5">削除</a>
                                    </div>
                                </div>
                            </div>
                            <div class="des-news col-xs-12">
                                <div class="row">
                                    <p>
                                        説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="news-content">
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <a href="news-edit.html">
                                <center>
                                    <img src="images/img-news.jpg" class="img-responsive" alt="">
                                </center>
                            </a>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <div class="title-news">
                                <div class="row">
                                    <div class="col-md-8 col-xs-12">
                                        <a href="news-edit.html" class="text-news-left">ュー追加</a>
                                        <p>クポン覧クポン</p>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <a href="" class="btn-5">削除</a>
                                    </div>
                                </div>
                            </div>
                            <div class="des-news col-xs-12">
                                <div class="row">
                                    <p>
                                        説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="news-content">
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <a href="news-edit.html">
                                <center>
                                    <img src="images/img-news.jpg" class="img-responsive" alt="">
                                </center>
                            </a>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <div class="title-news">
                                <div class="row">
                                    <div class="col-md-8 col-xs-12">
                                        <a href="news-edit.html" class="text-news-left">ュー追加</a>
                                        <p>クポン覧クポン</p>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <a href="" class="btn-5">削除</a>
                                    </div>
                                </div>
                            </div>
                            <div class="des-news col-xs-12">
                                <div class="row">
                                    <p>
                                        説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="news-content">
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <a href="news-edit.html">
                                <center>
                                    <img src="images/img-news.jpg" class="img-responsive" alt="">
                                </center>
                            </a>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <div class="title-news">
                                <div class="row">
                                    <div class="col-md-8 col-xs-12">
                                        <a href="news-edit.html" class="text-news-left">ュー追加</a>
                                        <p>クポン覧クポン</p>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <a href="" class="btn-5">削除</a>
                                    </div>
                                </div>
                            </div>
                            <div class="des-news col-xs-12">
                                <div class="row">
                                    <p>
                                        説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="news-content">
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <a href="news-edit.html">
                                <center>
                                    <img src="images/img-news.jpg" class="img-responsive" alt="">
                                </center>
                            </a>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <div class="title-news">
                                <div class="row">
                                    <div class="col-md-8 col-xs-12">
                                        <a href="news-edit.html" class="text-news-left">ュー追加</a>
                                        <p>クポン覧クポン</p>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <a href="" class="btn-5">削除</a>
                                    </div>
                                </div>
                            </div>
                            <div class="des-news col-xs-12">
                                <div class="row">
                                    <p>
                                        説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="news-content">
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <a href="news-edit.html">
                                <center>
                                    <img src="images/img-news.jpg" class="img-responsive" alt="">
                                </center>
                            </a>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <div class="title-news">
                                <div class="row">
                                    <div class="col-md-8 col-xs-12">
                                        <a href="news-edit.html" class="text-news-left">ュー追加</a>
                                        <p>クポン覧クポン</p>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <a href="" class="btn-5">削除</a>
                                    </div>
                                </div>
                            </div>
                            <div class="des-news col-xs-12">
                                <div class="row">
                                    <p>
                                        説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が入ります説明が...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-bottom">
                    <ul class="pagination"> 
                        <li class="disabled">
                            <a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a>
                        </li> 
                        <li class="active">
                            <a href="#">1 <span class="sr-only">(current)</span></a>
                        </li>
                        <li><a href="#">2</a></li> 
                        <li><a href="#">3</a></li> 
                        <li><a href="#">4</a></li> 
                        <li><a href="#">5</a></li> 
                        <li>
                            <a href="#" aria-label="Next"><span aria-hidden="true">»</span></a>
                        </li> 
                    </ul>
                </div>
            </div>
        </div>
    </section>
</aside>
<!-- /.right-side -->
@endsection

@section('footerJS')
<script src="{{ url('admin/js/lc_switch.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('input.lcs_check').lc_switch();        
    })
</script>
@endsection