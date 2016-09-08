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
    				<div id ="enduser-chat-list" class="list-group"></div>
    			</div>
    		</div>
    		<div id="message-wrapper" class="col-lg-9 col-md-9"></div>
    	</div>
        
        <div id="room-template" class="hide">
        	<div id="" class="rooms">
    	        <div class="panel panel-default">
    	            <div class="panel-heading"></div>
    	            <div class="panel-body">
    	                <ul class="messages scrollbar-macosx"></ul>
    	            </div>
    	            <div class="panel-footer">
    	                <div class="input-group">
                            <input type="text" class="form-control message_input" placeholder="Enter message...">
                            <span class="input-group-btn">
                                <button class="btn btn-default send_message" type="button">Send</button>
                            </span>
                        </div><!-- /input-group -->
    	            </div>
    	        </div>
    	    </div>
        </div>
        
        <div id="members-template" class="hide">
    	    <div class="list-group-item">
    			<div class="media">
    				<div class="media-left">
    					<a href="#">
    					  <img class="media-object" src="" alt="">
    					</a>
    				</div>
    				<div class="media-body">
    					<h4 class="media-heading"></h4>
    					<p></p>
    				</div>
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


function drawMessage(package){
	var $message;
	var side = 'left';
	if( package.user.profile.mid == profile.mid ){
	    side = 'right';
	}
	
  
 
    if( checkExistBoxItems(package.user.profile) ){
        renderChatLists(package.user.profile);
        renderChatBox(package.user.profile,function(valid){
            if( valid ){}
        });
        
    }
    
    $messages = $('div#box-'+ package.user.profile.mid +' ul.messages');
    $message = $($('.message_template').clone().html());
    $message.addClass(side).find('.text').html(package.message.message);
    $message.find('.avatar img').attr('src',package.user.profile.pictureUrl+'/small')
    $message.find('.timestamp').text( converTimestamp(package.message.timestamp));
    
    $messages.append($message);
    
    
    setTimeout(function () {
        return $message.addClass('appeared');
    }, 0);
    
    return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
  
};



// Send message text enduser typing   
function sendMessage(target) {
    // Draw message client
    console.log(target);
    var closest = $(target).closest('.panel');
    var $messages, message;
    if ($(closest).find('input').val().trim() === '') {
        return;
    }
    
    $messages = $(closest).find('ul.messages');
    

    var d = new Date();
    $message = $($('.message_template').clone().html());
    $message.addClass('right').find('.text').html($(closest).find('input').val() );
    $message.find('.avatar img').attr('src',profile.pictureUrl+'/small')
    $message.find('.timestamp').text(converTimestamp(d.getTime()/1000));
    $messages.append($message);
    setTimeout(function () {
        return $message.addClass('appeared');
    }, 0);
    // Send message to server
    var d = new Date();
    var params = {
        'to': $(closest).attr('data-id'),
        'message': $(closest).find('input').val(),
        'timestamp': d.getTime()/1000
    };
    socket.emit('send.admin.message',params);
    $(closest).find('input').val('')
    return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
};

// Connect to server 
function connectToChat() {
    socket = new io.connect('{{ env('CHAT_SERVER') }}', {
        'reconnection': true,
        'reconnectionDelay': 1000,
        'reconnectionDelayMax' : 5000,
        'reconnectionAttempts': 5
    });
    
    socket.on('connect', function (user) {
        console.log('Request connect');
        var package = {
            from: 'client',
            channel: channel,
            profile: profile
        }
        socket.emit('join', package);
    });
    
    socket.on('receive.admin.message',function( package ){
        drawMessage(package);
        console.log('Client send');
        console.log(package);
    })

    socket.on('history',function(package){
        console.log('history');
        console.log(package);
        if( package.length > 0 ){
            $(package).each(function(index, item) {
                $(item.history).each(function(index1, item1){
                    var where = (function(){
                        if(item1.from_mid === profile.mid)
                            return item1.from_mid
                        else{
                            return item1.to_mid
                        }
                    })();
                    console.log('where'+where);
                    var temp = {
                        message:{
                            message: item1.message,
                            timestamp: item1.created_at
                        },
                        user: {
                            channel: item1.room_id,
                            profile: {
                                displayName: item1.displayName,
                                mid: where,
                                pictureUrl: item1.pictureUrl,
                            }
                        }
                        
                    };
                    drawMessage(temp);
                })
              
            });
        }
        
    })
    
    socket.on('receive.admin.connected',function(package){
      drawSystemMessage(package);
    })
    
    socket.on('receive.admin.disconnect',function(package){
      drawSystemMessage(package);
    })
}


function drawSystemMessage(package){
    
}

function displayListEndUsers(endUsers){
    $(endUsers).each(function(index,item){
        if( item.mid !== item.roomid ){
            if( checkExistBoxItems(item) )
                renderChatLists(item);
                renderChatBox(item);
        }
    });
}

function checkExistBoxItems(profile){
    if(  
        $('#enduser-chat-list #'+profile.mid) != typeof undefined &&
        $('#enduser-chat-list #'+profile.mid).length > 0 ){
        return false;
    }else{
        return true;
    }

    
}


function renderChatLists(profile){
    var $template;
    $template = $($('#members-template').clone().html());
    $template.attr('id',profile.mid).addClass('rendered');
    $template.find('.media-object').attr('src',profile.pictureUrl+'/small');
    $template.find('.media-heading').html(profile.displayName);
    $template.find('.media-body p').text(profile.statusMessage);
      
    $('#enduser-chat-list').append($template);
    return setTimeout(function () {
        return $template.addClass('appeared');
    }, 0);
}


function renderChatBox(profile,callback){
    
    var $template;
    $template = $($('#room-template .rooms').clone().html());
    $template.attr('id','box-'+profile.mid).attr('data-id',profile.mid)
        .find('.panel-heading').html(profile.displayName);
    $('#message-wrapper').append($template);
    callback(true);
}

function converTimestamp(timestamp){
  var d = new Date(timestamp);
  return d.getHours()+'h:'+d.getMinutes()+'m:'+d.getSeconds()+'s '+d.getDay()+'-'+d.getMonth()+'-'+d.getUTCFullYear();
}

$(document).ready(function(){
    $('.scrollbar-macosx').scrollbar();
    console.log('Connect to chat');
    connectToChat();
    
    $('#message-wrapper').on('keyup','.message_input',function (e) {
        if (e.which === 13) {
            return sendMessage(this);
        }
    });
    
    $('#message-wrapper').on('click','.send_message',function(e){
        return sendMessage(this);
    	
    })
});
</script>
@stop