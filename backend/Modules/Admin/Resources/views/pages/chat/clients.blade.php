@extends('admin::layouts.default')
@section('title', 'メニュー')

@section('content')
<style>
    .panel{
        max-width: 300px;
        margin: 5px;
        float:left;
    }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="{{ secure_asset('assets/css/chat.css') }} "/>
	<div class="content">
    	<div class="rows">
    		<div class="col-lg-3 col-md-3">
    			<div id="" style="margin-top:5px;">
    				<div id ="enduser-chat-list" >
    				    <div id="seach-wrapper" class="">
                            <input id="search_input" type="text" class="form-control" placeholder="Search...">
                        </div><!-- /input-group -->
                        <div id="contacts-list-wrapper" class="">
            			</div>
    				</div>
    			</div>
    		</div>
    		<div id="message-wrapper" class="col-lg-9 col-md-9"></div>
    		<iframe src="https://admin-official.line.me/" frameborder="0" width="100%" height="600"> </iframe>
    	</div>
        
        <div id="room-template" class="hide">
        	<div id="" class="rooms">
    	        <div class="panel panel-default"　style="border-color: white;">
    	            <div class="panel-heading">
    	                <span class="name"></span>
    	                <span class="status" style="color:red">Online</span>
    	            </div>
    	            <div class="panel-body">
    	                <ul class="messages scrollbar-macosx"></ul>
    	            </div>
    	            <div class="panel-footer">
                          <div class="input-group input-message">
                              <input type="text" class="form-control message_input" placeholder="メッセージを入力してください...">
                              <span class="input-group-btn input-group-addon">
                                  <a class="send_message">送信</a>
                              </span>
                          </div><!-- /input-group -->
    	            </div>
    	        </div>
    	    </div>
        </div>
        
        <div id="members-template" class="hide">
			<div class="media">
				<div class="media-left">
					<a href="#">
					  <img class="media-object" src="" alt="">
					</a>
				</div>
				<div class="media-body">
					<h5 class="media-heading"></h5>
					<p></p>
				</div>
			</div>
        </div>
        
        <div class="message_template" style="display:none">
            <li class="message">
                <div class="avatar">
                    <img src="">
                </div>
                <div class="text_wrapper">
                    <div class="text"></div>
                    <div class="timestamp"></div>
                </div>
            </li>
        </div>
        <div class="message_template_system" style="display:none">
            <li class="text-center">
                <p class="text-muted"></p>
            </li>
        </div>
    </div>	<!-- end main-content-->
    <div class="clearfix"></div>
@stop
@section('script')
<script type="text/javascript" src="{{ secure_asset('assets/js/jquery-1.11.2.min.js') }} "></script>
<script type="text/javascript" src="{{ secure_asset('assets/plugins/jquery.scrollbar/jquery.scrollbar.min.js') }} "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.min.js"></script>  

<script type="text/javascript">

var socket;
var profile = $.parseJSON('<?php echo ($profile) ?>');
var channel = '{{ $channel }}';
var noavatar = '{{url("assets/images/noavatar.png")}}';
var contactsData = $.parseJSON('<?php echo ($contacts) ?>');

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
function drawMessage( windows, message){
	var $message,
	    $messages,
	    profileTemp = message.profile;
	    
	var side = 'left';
	if( message.profile.mid == profile.mid ){
	    side = 'right';
	    profileTemp = profile;
	    
	}
	// Generate item message
	$message = $($('.message_template').clone().html());
    $message.addClass(side).find('.text').html( message.text );
    $message.find('.avatar img').attr('src', profileTemp.pictureUrl +'/small')
    $message.find('.timestamp').text( converTimestamp(message.timestamp) );
    $message.addClass('appeared');
	// Append to windows
	windows.find('ul.messages').append($message);
    return windows.find('ul.messages').animate({ scrollTop: windows.find('ul.messages').prop('scrollHeight') }, 300);
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

// Send message text enduser typing   
function sendMessage(target) {
    // Draw message client
    var d = new Date();
    var closest = $(target).closest('.panel');
    if ($(closest).find('input').val().trim() === '') {
        return;
    }
    var message = {
            text: $(closest).find('input').val(),
            timestamp: converTimestamp(d.getTime()/1000),
            channel: '',
            profile: {
                displayName: profile.displayName,
                mid: profile.mid,
                pictureUrl: profile.pictureUrl,
            }
        };
    
    drawMessage(closest, message);
    // Send message to server
    socket.emit('send.admin.message',{
        'to': $(closest).attr('data-id'),
        'message': $(closest).find('input').val(),
        'timestamp': d.getTime()/1000
    });
    $(closest).find('input').val('');
   
};

// Connect to server 
function connectToChat() {
    socket = new io.connect("{{ env('CHAT_SERVER') }}", {
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
        $( contactsData.data ).each(function(index, item) {
            for( i in users){
                if( users[i].mid === item.mid ){
                    $('#con'+item.mid).find('.media-heading').html('<span class="status on"></span>');
                }
            }
            
        })
   
    })
    
    // Receive messages from endusers
    socket.on('receive.admin.message',function( package ){
        console.log('Receive messages from endusers');
        console.log(package);
        findWindows( package.windows, function(windows){
            drawMessage(windows, package.message);
        });
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
        
        findWindows(package.windows,function( $windows ){
            $(package.history).each(function(index, item){
                drawMessage($windows, {
                    text: item.message,
                    timestamp: converTimestamp(item.created_at) ,
                    profile: (function(){
                            if(item.from_mid === profile.mid)
                                return profile;
                            else{
                                return {
                                    displayName: item.displayName,
                                    mid: item.mid,
                                    pictureUrl: item.pictureUrl,
                                }
                            }
                        })()
                });
            })

	    })
       
       
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


function renderChatLists(contacts){
    
    if( contacts.length > 0){
        $('#contacts-list-wrapper').html('');
    }
    
    $(contacts).each(function(index,item){
        var $template;
        $template = $($('#members-template').clone().html());
        $template.attr('id','con'+item.mid).addClass('rendered');
        if( item.pictureUrl === ''  ){
            $template.find('.media-object').attr('src',noavatar);
        }else{
            $template.find('.media-object').attr('src',item.pictureUrl+'/small');
        }
        
        $template.find('.media-heading').html(item.displayName);
        $template.find('.media-body p').text(item.statusMessage);
          
        $('#contacts-list-wrapper').append($template);
        return setTimeout(function () {
            return $template.addClass('appeared');
        }, 0);
    });
   
}



function converTimestamp(timestamp){
  var d = new Date(timestamp);
  return d.getHours()+'h:'+d.getMinutes()+'m:'+d.getSeconds()+'s '+d.getDay()+'-'+d.getMonth()+'-'+d.getUTCFullYear();
}



$(document).ready(function(){
    $('.scrollbar-macosx').scrollbar();
    // Connect chat
    connectToChat();
    // Renders list chat
    renderChatLists(contactsData.data);
    // Enter send message
    $('#message-wrapper').on('keyup','.message_input',function (e) {
        if (e.which === 13) {
            return sendMessage(this);
        }
    });
    // Click button send message
    $('#message-wrapper').on('click','.send_message',function(e){
        return sendMessage(this);
    	
    })
    
    
    // Search contact
    $('#search_input').on('keyup',function (e) {
        var s = $(this).val();
        if (e.which === 13 && s.length > 0) {
            $.ajax({
               url: '{{ route("chat.seach.contact") }}',
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
            renderChatLists(contactsData.data);
        }
    });
    
    // Open windows chat and load history 
    
    $('#contacts-list-wrapper').on('click','.media',function(e){
        console.log('Open windows by contact: '+$(this).attr('id').substr(3));
        socket.emit('admin.send.history', $(this).attr('id').substr(3) );
    })
    
    
});
</script>
@stop