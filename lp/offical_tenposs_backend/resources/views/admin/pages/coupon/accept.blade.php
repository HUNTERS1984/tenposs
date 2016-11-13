@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
            <div class="wrapp-breadcrumds">
                <div class="left"><span>承認管理</span><span class="circle-bre">12</span></div>
                <div class="left">
                  <div class="tab-header-accept">
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation">
                          <a href="#tab-accept-1" aria-controls="tab-accept-1" role="tab" data-toggle="tab">全て</a>
                        </li>
                        <li role="presentation">
                          <a href="#tab-accept-2" aria-controls="tab-accept-1" role="tab" data-toggle="tab">未承認</a>
                        </li>
                        <li role="presentation">
                          <a href="#tab-accept-3" aria-controls="tab-accept-3" role="tab" data-toggle="tab">承認済み</a>
                        </li>
                      </ul>
                  </div>
                </div>
            </div>
            <section class="content">
        <div class="col-md-12">
          <div class="main-search-btn">
            <div class="row">
              <div class="col-md-6">
                <div class="wrapp_search_btn">
                  <form class="form-group">
                              <input type="text" class="form-control has-feedback-left" id="" placeholder="ユーザー名/ハッシュタグを入力してください">
                              <span class="fa fa-search form-control-feedback left" aria-hidden="true"></span>
                          </form>
                        </div>
              </div>
              <div class="col-md-6">
                <div class="search-right">
                  <a href="#" class="btn-s-1" id="btn_approve">選択したユーザーを承認</a>
                  <a href="{{route('admin.coupon.approve_all')}}" class="btn-s-2" onclick="return confirm('Are you sure?')">すべてのユーザーを承認</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- poup accept -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
            <div class="modal-dialog photo_accept" role="document">
                <div class="modal-content mana_accept">
                    <div class="modal-body">
                        <img src="images/photo_user.jpg" class="img-responsive" alt="" id="modal_image">
                        <div class="meta-footer">
                            <span id="modal_hashtag"></span>
                        </div>
                    </div>
                </div>
                <div class="wrapp_btn_close_poup_photo">
                    <button type="button" class="btn_mana_accept" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
            </div>
        </div>
        <!-- //poup accept -->

        <div class="col-md-12">
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="tab-accept-1">
              <div class="wrapp_table">

                    <!-- table -->
                    <div class="table-responsive">
                        <table class="table accept_01">
                            <thead>
                            <tr>
                                <th class="center">選択</th>
                                <th></th>
                                <th>ユーザーネーム</th>
                                <th>投稿写真</th>
                                <th>ハッシュタグ</th>
                                <th class="center">ステータス</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <th width="8%" scope="row" class="center">
                                        <div>
                                            <input id="{{$post->id}}" class="checkbox-custom" name="checkbox-1" type="checkbox">
                                            <label for="{{$post->id}}" class="checkbox-custom-label"></label>
                                        </div>
                                    </th>
                                    <td width="10%" class="center">
                                        <img src="{{$post->avatar}}" alt="">
                                    </td>
                                    <?php
                                    $tag_str = '';
                                    foreach ($post->tags as $tag) {
                                        $tag_str .= "#".$tag->tag. ' ';
                                    }
                                    ?>
                                    <td width="20%">{{$post->username}}</td>
                                    <td width="10%">
                                        <a href="" title="" data-imageurl="{{ $post->image_url }}" data-hashtag="{{ $tag_str }}" class="blue" data-toggle="modal" data-target="#myModal">
                                            写真を確認する
                                        </a>
                                    </td>
                                   
                                    <td width="40%">{{$tag_str}}</td>
                                    <?php if ($post->status == 0) { ?>
                                    <td width="8%" class="center"><a href="{{route('admin.coupon.approve.post',['post_id'=>$post->id])}}" title="" class="red">未承認</a></td>
                                    <?php } else { ?>
                                    <td width="8%" class="center"><a href="{{route('admin.coupon.unapprove.post',['post_id'=>$post->id])}}" title="">承認済み</a></td>
                                    <?php } ?>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(count($posts) > 0)
                        {{ $posts->render() }}
                    @endif
                    <!-- //table -->
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab-accept-2">
              <div class="wrapp_table">

                    <!-- table -->
                    <div class="table-responsive">
                        <table class="table accept_01">
                            <thead>
                            <tr>
                                <th class="center">選択</th>
                                <th></th>
                                <th>ユーザーネーム</th>
                                <th>投稿写真</th>
                                <th>ハッシュタグ</th>
                                <th class="center">ステータス</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notapproved_posts as $post)
                                <tr>
                                    <th width="8%" scope="row" class="center">
                                        <div>
                                            <input id="{{$post->id}}" class="checkbox-custom" name="checkbox-1" type="checkbox">
                                            <label for="{{$post->id}}" class="checkbox-custom-label"></label>
                                        </div>
                                    </th>
                                    <td width="10%" class="center">
                                        <img src="{{$post->avatar}}" alt="">
                                    </td>
                                    <?php
                                    $tag_str = '';
                                    foreach ($post->tags as $tag) {
                                        $tag_str .= "#".$tag->tag. ' ';
                                    }
                                    ?>
                                    <td width="20%">{{$post->username}}</td>
                                    <td width="10%">
                                        <a href="" title="" data-imageurl="{{ $post->image_url }}" data-hashtag="{{ $tag_str }}" class="blue" data-toggle="modal" data-target="#myModal">
                                            写真を確認する
                                        </a>
                                    </td>
                                   
                                    <td width="40%">{{$tag_str}}</td>
                                    <?php if ($post->status == 0) { ?>
                                    <td width="8%" class="center"><a href="{{route('admin.coupon.approve.post',['post_id'=>$post->id])}}" title="" class="red">未承認</a></td>
                                    <?php } else { ?>
                                    <td width="8%" class="center"><a href="{{route('admin.coupon.unapprove.post',['post_id'=>$post->id])}}" title="">承認済み</a></td>
                                    <?php } ?>
                                </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                    </div>
                    @if(count($notapproved_posts) > 0)
                        {{ $notapproved_posts->render() }}
                    @endif
                    <!-- //table -->
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab-accept-3">
              <div class="wrapp_table">

                    <!-- table -->
                    <div class="table-responsive">
                        <table class="table accept_01">
                            <thead>
                            <tr>
                                <th class="center">選択</th>
                                <th></th>
                                <th>ユーザーネーム</th>
                                <th>投稿写真</th>
                                <th>ハッシュタグ</th>
                                <th class="center">ステータス</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($approved_posts as $post)
                                <tr>
                                    <th width="8%" scope="row" class="center">
                                        <div>
                                            <input id="{{$post->id}}" class="checkbox-custom" name="checkbox-1" type="checkbox">
                                            <label for="{{$post->id}}" class="checkbox-custom-label"></label>
                                        </div>
                                    </th>
                                    <td width="10%" class="center">
                                        <img src="{{$post->avatar}}" alt="">
                                    </td>
                                    <?php
                                    $tag_str = '';
                                    foreach ($post->tags as $tag) {
                                        $tag_str .= "#".$tag->tag. ' ';
                                    }
                                    ?>
                                    <td width="20%">{{$post->username}}</td>
                                    <td width="10%">
                                        <a href="" title="" data-imageurl="{{ $post->image_url }}" data-hashtag="{{ $tag_str }}" class="blue" data-toggle="modal" data-target="#myModal">
                                            写真を確認する
                                        </a>
                                    </td>
                                   
                                    <td width="40%">{{$tag_str}}</td>
                                    <?php if ($post->status == 0) { ?>
                                    <td width="8%" class="center"><a href="{{route('admin.coupon.approve.post',['post_id'=>$post->id])}}" title="" class="red">未承認</a></td>
                                    <?php } else { ?>
                                    <td width="8%" class="center"><a href="{{route('admin.coupon.unapprove.post',['post_id'=>$post->id])}}" title="">承認済み</a></td>
                                    <?php } ?>
                                </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                    </div>
                    @if(count($approved_posts) > 0)
                        {{ $approved_posts->render() }}
                    @endif
                    <!-- //table -->
                </div>
            </div>
          </div>
        </div>
            </section>
        </aside>
<!-- /.right-side -->
@endsection

@section('footerJS')
<script type="text/javascript">
    $(document).ready(function () {
        var approve_list = [];
        $('#myModal').on('show.bs.modal', function (e) {
            var link = $(e.relatedTarget);
            var modal = $(this);
            $('#modal_image').attr('src',link.data("imageurl"));
            $('#modal_hashtag').text(link.data("hashtag"));

        });

        $('#btn_approve').click(function () {
            $("input[type=checkbox]:checked").each(function(){
                approve_list.push($(this).attr('id'));
            });

            console.log(approve_list);

            $.ajax({
                type: "POST",
                url: "/admin/coupon/approve",
                data: {data: approve_list}
            }).done(function (data) {
                location.reload();
            });

        });
    })
    $(".nav-tabs > li.active").removeClass("active");
    $(".tab-pane").removeClass("active");
    if(window.location.href.indexOf("no_coupon") > -1) {
       $("#tab-accept-2").addClass("active");
       $(".nav-tabs > li:nth-child(2)").addClass("active");
    } else if(window.location.href.indexOf("yes_coupon") > -1) {
       $("#tab-accept-3").addClass("active");
       $(".nav-tabs > li:nth-child(3)").addClass("active");
    } else {
       $("#tab-accept-1").addClass("active");
       $(".nav-tabs > li:nth-child(1)").addClass("active");
    }
</script>
@endsection