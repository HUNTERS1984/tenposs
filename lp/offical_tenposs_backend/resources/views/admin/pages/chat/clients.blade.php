@extends('admin.layouts.master')

@section('main')
 <aside class="right-side">
    <div class="wrapp-breadcrumds">
        <div class="left">
            <span>チャット</span><!-- <span class="circle-bre">19</span> -->
            <strong>顧客のチャットが可能 </strong>
        </div>
    </div>
    <section class="content">
        <div class="col-sm-12">@include('admin.layouts.messages')</div>
        
        <div class="wrapp-user-chat">
            <div class="left-user-chat">
                <div class="wrapp_search_user_chat">
                    <form class="form-horizontal">
                        <div class="input-group">
                            <input id="search_input" type="text" class="form-control" placeholder="ユーザー名">
                            <a href="javascript:void(0)" class="input-group-addon">
                                <img src="{{ url('admin/images/search.png') }}" alt="">
                            </a>
                        </div>
                    </form>
                </div>
                <div id="contacts-lists" class="list-user" data-ss-container>
                    <ul class="nav-list-user"></ul>
                </div>
            </div>
            <div class="right-user-chat">
                <div class="wrapp-thumb-user-chat">
                    <div class="img-thumb-user-chat">
                        <img id="chatting-user-avatar" src="" alt="">
                    </div>
                    <div class="title-thumb-user-chat">
                        <span id="chatting-user-name"></span>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="log-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog user-poup-log" role="document">
                        <div class="modal-content">
                            <h4>本当に削除しますか?</h4>
                            <div class="col-md-6 col-xs-6">
                                <a href="" class="btn-user-poup-log-poup-left">キャンセル</a>
                            </div>
                            <div class="col-md-6 col-xs-6">
                                <a href="" class="btn-user-poup-log-poup-right">削除</a>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="dropdown drop-user-top">
                        <a href="" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="glyphicon glyphicon-cog"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li>
                                <a href="" data-toggle="modal" data-target="#log-user">
                                    スレッドを削除する
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="form-middle-user">
                    <div class="con-scroll-right" data-ss-container>
                        <div id="messages-windows" class="chat-body clearfix"></div>
                    </div>
                </div>
                <div id="message-wrapper"  class="form-text-user">
                    <div class="row">
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="col-md-9">
                            <input type="text" id="message_input" class="form-control" placeholder="">
                        </div>
                        <div class="col-md-2">
                            <button id="send_message" type="button" class="btn btn-primary">送信</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</aside>
<!-- /.right-side -->

<div id="members-template" class="hide">   
	<li id=""  class="">
        <a href="#">
            <div class="left-list-user">
                <div class="img-user-chat">
                    <img src="" alt="">
                </div>
                <div class="title-user-chat">
                    <p><strong class="users-name"></strong></p>
                    <p class="users-status"></p>
                </div>
            </div>
            <div class="right-list-user">
                <p class="time-user-chat"></p>
                <p class="count-user-chat"></p>
            </div>
        </a>
    </li>
</div> 
<div id="messages-template" class="hide">
   <div class="answer">
        <div class="avatar">
            <img src="" alt="">
        </div>
        <div class="text"></div>
        <div class="time"><span></span></div>
    </div>
</div>

@stop
@section('footerJS')
<script src="{{ secure_asset('assets/js/socket.io.min.js') }}"></script>
<script src="{{ url('admin/js/simple-scrollbar.js') }}"></script>
<script src="{{ url('admin/js/moment.min.js') }}"></script>
<script type="text/javascript">SimpleScrollbar.initAll();</script>
<script type="text/javascript">

var socket;
var profile = $.parseJSON('{!! (isset($profile)) ? $profile : "" !!}');
var channel = '{{ (isset($channel)) ? $channel : "" }}';
var noavatar = '{{ url("assets/images/noavatar.png") }}';
var contactsData = $.parseJSON('{!!  (isset($contacts)) ? $contacts : "" !!}');

/*  windows: {
        mid: string,
        displayName: string
    }
    message:{
        text: string,
        timestamp: string,
        channel: string,
        profile: {
            displayName: string,
            mid: string,
            pictureUrl: string,
        }
    }
*/
function drawMessage(message){
	var $message,
	    $messages,
	    profileTemp = message.profile;
	    
	var side = 'left';
	if( message.profile.mid == profile.mid ){
	    side = 'right';
	    profileTemp = profile;
	}

	// Generate item message
	$message = $($('#messages-template').clone().html());
    $message.addClass(side).find('.text').html( message.text );
    if( profileTemp.pictureUrl === null ){
        $message.find('.avatar img').attr('src', noavatar)
    }else{
        $message.find('.avatar img').attr('src', profileTemp.pictureUrl +'/small')
    }

    $message.find('.time').text( moment(message.timestamp).format('LTS') );
    $message.addClass('appeared');
	// Append to windows
	$('#messages-windows').append($message);
    return $('.ss-content').animate({ scrollTop: $('.ss-content').prop('scrollHeight') });
};

/*
windows: {
    displayName: string,
    mid: string,
}
*/

function findWindows(info , _callback){
    var $box = $('#message-wrapper #'+ info.mid);
    if( $box != typeof undefined && $box.length > 0 ){
        return _callback( $box );
    }else{
        drawWindows(info,function( $box ){
             return _callback($box);
        })
    }
}
/*
windows: {
    displayName: string,
    mid: string,
}
*/
function drawWindows(info, _callback){
    var $template;
    $template = $($('#room-template .rooms').clone().html());
    $template.attr('id',info.mid).attr( 'data-id',info.mid )
        .find('.panel-heading span.name').html( info.displayName );
    $('#message-wrapper').append( $template );
    _callback( $template );
    
}


function sendMessage(target) {
    var d = new Date();
    var closest = $(target).closest('#message-wrapper');
    if ( $(closest).find('input').val().trim() === '' ) {
        return;
    }
    var message = {
        text: $(closest).find('input').val(),
        timestamp: d.getTime(),
        channel: '',
        profile: {
            displayName: profile.displayName,
            mid: profile.mid,
            pictureUrl: profile.pictureUrl,
        }
    };
    
    drawMessage(message);
    // Send message to server
    var package = {
        'from' : profile.mid,
        'to': $(closest).attr('data-id'),
        'app_user_id' : '{{ Session::get("user")->id }}',
        'message': $(closest).find('input').val(),
        'timestamp': d.getTime()
    };
    console.log(package);
    socket.emit('send.admin.message',package);
    $(closest).find('input').val('');
   
};

// Connect to server 
function connectToChat() {
    socket = new io.connect("{{ config('line.CHAT_SERVER') }}", {
        'reconnection': true,
        'reconnectionDelay': 1000,
        'reconnectionDelayMax' : 5000,
        'reconnectionAttempts': 5
    });
    
    socket.on('connect', function (user) {
        console.log('Request connect to server');
        var package = {
            from: 'client',
            channel: channel,
            profile: profile
        }
        socket.emit('join', package);
    });
    
    // Validate contacts list is online
    /**
     * users: array[mid]
     */ 
    socket.on('receive.admin.getClientOnline',function(users){
        console.log('List users online');
        console.log(users);
        $( contactsData ).each(function(index, item) {
            for( i in users){
                if( users[i].mid === item.mid ){
                    $('#con'+item.mid).find('.count-user-chat').addClass('on');
                }
            }
            
        })
   
    })
    
    // Receive messages from endusers
    socket.on('receive.admin.message',function( package ){
        console.log('Receive messages from endusers');
        console.log(package);

        // draw if windown active
        if( $('#message-wrapper').attr('data-id') == package.message.profile.mid ){
            drawMessage(package.message);
        }

        // draw in to chat list
        if( ! $('ul.nav-list-user li#con'+package.message.profile.mid).length ){
            var $template;
            $template = $($('#members-template').clone().html());
            $template.attr('id','con'+ package.message.profile.mid).addClass('rendered');
            if( package.message.profile.pictureUrl === null  ){
                $template.find('img').attr('src',noavatar);
            }else{
                $template.find('img').attr('src',package.message.profile.pictureUrl+'/small');
            }

            $template.find('.users-name').html(package.message.profile.displayName);
            $template.find('.users-status').text( trimwords(package.message.text,30) );
            $template.find('.count-user-chat').addClass('on');
            $('.nav-list-user').prepend($template);
        }else{
            // update online status text
            $('ul.nav-list-user li#con'+package.message.profile.mid).find('.users-status').text( trimwords(package.message.text,30) );
            $('ul.nav-list-user li#con'+package.message.profile.mid).find('.count-user-chat').addClass( 'on' );
        }

    })

    socket.on('history',function(package){
        console.log('Load history message');
        console.log(package);
        if( package.length > 0 ){


            $(package).each(function(index, item) {

                $(item.history).each(function(index1, item1){
                    var profileTemp = (function(){
                        if(item1.from_mid === profile.mid)
                            return profile;
                        else{
                            return {
                                displayName: item1.displayName,
                                mid: item1.mid,
                                pictureUrl: item1.pictureUrl,
                            }
                        }
                    })();

                    drawMessage({
                        windows: item.windows,
                        message: item1.message,
                        timestamp: item1.created_at,
                        profile: profileTemp
                    });
                })
              
            });
        }
        
    })
    
    socket.on('receive.admin.connected',function(package){
        package.status = 'Online';
        drawSystemMessage(package);
    })
    
    socket.on('receive.admin.disconnect',function(package){
        package.status = 'Offline';
        drawSystemMessage(package);
    })
    
    socket.on('receive.admin.history', function( package ){
        console.log('History client');
        console.log(package);
        $('#messages-windows').empty();


        for ( i = package.history.length - 1; i >= 0; i--) {
            drawMessage({
                text: package.history[i].message,
                timestamp: moment( parseInt(package.history[i].created_at) ).format() ,
                profile: (function(){
                    if(package.history[i].from_mid === profile.mid)
                        return profile;
                    else{
                        return {
                            displayName: package.windows.displayName,
                            mid: package.windows.mid,
                            pictureUrl: package.windows.pictureUrl,
                        }
                    }
                })()
            });
        }
        /*
        $(package.history).each(function(index, item){
            drawMessage({
                text: item.message,
                timestamp: moment( parseInt(item.created_at) ).format() ,
                profile: (function(){
                    if(item.from_mid === profile.mid)
                        return profile;
                    else{
                        return {
                            displayName: package.windows.displayName,
                            mid: package.windows.mid,
                            pictureUrl: package.windows.pictureUrl,
                        }
                    }
                })()
            });
        })
        */
       
    });
}

function drawSystemMessage(package){
    console.log('System mesage'+ JSON.stringify(package) );

    findWindows(package.user.profile, function($box) {
        $box.find('span.status').text(package.status);
        var $messages = $box.find('ul.messages');
        var $message = $($('.message_template_system').clone().html());
        $message.find('p').text(package.message);
        $messages.append($message);
        setTimeout(function () {
          return $messages.addClass('appeared');
        }, 0);
        return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
    } );
   
    
}

function trimwords( words, number ){

    if( words.length > number){

        var trimmedString = words.substr(0, number);
        //re-trim if we are in the middle of a word
        trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")));
        return trimmedString;
    }else{
        return words;
    }
}

function renderChatLists(contacts){
    if( contacts.length > 0){
        $('.nav-list-user').html('');
    }
    $(contacts).each(function(index,item){
        var $template;
        $template = $($('#members-template').clone().html());
        $template.attr('id','con'+ item.mid).addClass('rendered');
        if( item.pictureUrl === null  ){
            $template.find('img').attr('src',noavatar);
        }else{
            $template.find('img').attr('src',item.pictureUrl+'/small');
        }
        
        $template.find('.users-name').html(item.displayName);
        $template.find('.users-status').text(item.statusMessage);
        $('.nav-list-user').append($template);
    });
}




$(document).ready(function(){
    //$('.scrollbar-macosx').scrollbar();
    // Connect chat
    connectToChat();
    // Renders list chat
    renderChatLists(contactsData);
    // Enter send message
    $('#message-wrapper').on('keyup','#message_input',function (e) {
        if (e.which === 13) {
            return sendMessage(this);
        }
    });
    // Click button send message
    $('#message-wrapper').on('click','#send_message',function(e){
        return sendMessage(this);
    	
    });
    // Search contact
    $('#search_input').on('keyup',function (e) {
        var s = $(this).val();
        if (e.which === 13 && s.length > 0) {
            $.ajax({
               url: '{{ route("chat.search.contact") }}',
               type: 'post',
               data:{
                   s : s,
               },
               success: function(response){
                   if ( response ){
                       renderChatLists(response.data);
                   }
                   console.log(response);
               }
            });
        }else if( s.length === 0 ){
            renderChatLists(contactsData);
        }
    });
    
    // Open windows chat and load history 
    $('.nav-list-user').on('click','li',function(e){
        e.preventDefault();
        console.log('Open windows chat');
        // active
        $('.nav-list-user li').removeClass('active');
        $(this).addClass('active');
        // Set windows avatar and username
        $('#chatting-user-avatar').attr('src', $(this).find('img').attr('src') );
        $('#chatting-user-name').text( $(this).find('.users-name').text() );
        // Set data-mid to windows chat
        $('#message-wrapper').attr('data-id', $(this).attr('id').substr(3) );
        socket.emit('admin.send.history', $(this).attr('id').substr(3) );
    })

});
</script>
@stop