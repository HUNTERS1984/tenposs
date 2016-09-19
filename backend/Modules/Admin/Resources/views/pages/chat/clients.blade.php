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
    				    <div id="seach-wrapper" class="input-group">
                            <input id="search_input" type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button">OK</button>
                            </span>
                        </div><!-- /input-group -->
                        <div id="contacts-list-wrapper" class="scrollbar-macosx">
            			</div>
    				</div>
    			</div>
    		</div>
    		<div id="message-wrapper" class="col-lg-9 col-md-9"></div>
    	</div>
        
        <div id="room-template" class="hide">
        	<div id="" class="rooms">
    	        <div class="panel panel-default">
    	            <div class="panel-heading">
    	                <span class="name"></span>
    	                <span class="status" style="color:red">Online</span>
    	            </div>
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
var noavatar = '{{url('assets/images/noavatar.png')}}';
var contacts;
var contactsData = $.parseJSON('<?php echo ($contacts) ?>');


function drawMessage(package){
	var $message,$messages;
	var side = 'left';
	if( package.user.profile.mid == profile.mid ){
	    side = 'right';
	}
	
	checkExistBoxItems(package.user.profile,function( $box ){

        $message = $($('.message_template').clone().html());
        $message.addClass(side).find('.text').html(package.message.message);
        $message.find('.avatar img').attr('src',package.user.profile.pictureUrl+'/small')
        $message.find('.timestamp').text( converTimestamp(package.message.timestamp));
        $box.find('ul.messages').append($message);
            
        setTimeout(function () {
            return $message.addClass('appeared');
        }, 0);
        
        return $box.find('ul.messages').animate({ scrollTop: $box.find('ul.messages').prop('scrollHeight') }, 300);
	     
	 })

};
function checkExistBoxItems(profile, _callback){
    var $box = $('#message-wrapper #'+profile.boxid);
    if( $box != typeof undefined && $box.length > 0 ){
        return _callback( $box );
    }else{
        renderChatBox(profile,function( $box ){
             return _callback($box);
        })
    }
}

function renderChatBox(profile,_callback){
    
    var $template;
    $template = $($('#room-template .rooms').clone().html());
    $template.attr('id',profile.boxid).attr('data-id',profile.boxid)
        .find('.panel-heading span.name').html(profile.displayName);
    $('#message-wrapper').append($template);
    _callback($template);
    
}

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
    
    
    socket.on('receive.admin.getClientOnline',function(users){
        console.log(users);
        var onlines = $.grep(users, function(element) {
            return $.inArray(element, contacts.data ) !== -1;
        });
    })
    
    socket.on('receive.admin.message',function( package ){
        package.user.profile.boxid = package.user.profile.mid;
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
                    var profileTemp = (function(){
                        if(item1.from_mid === profile.mid)
                            return {
                                displayName: profile.displayName,
                                mid: profile.mid,
                                pictureUrl: profile.pictureUrl,
                                boxid: item1.mid
                            }
                        else{
                            return {
                                displayName: item1.displayName,
                                mid: item1.mid,
                                pictureUrl: item1.pictureUrl,
                                boxid: item1.mid
                            }
                        }
                    })();
                
                    var temp = {
                        message:{
                            message: item1.message,
                            timestamp: item1.created_at
                        },
                        user: {
                            channel: item1.room_id,
                            profile: profileTemp
                        }
                        
                    };
                    drawMessage(temp);
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
}


function drawSystemMessage(package){
    console.log('system mesage'+ JSON.stringify(package) );
    package.user.profile.boxid = package.user.profile.mid;
    checkExistBoxItems(package.user.profile, function($box) {
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
    console.log('Connect to chat');
    connectToChat();
    
    contacts = $('#contacts-list-wrapper').clone();
    renderChatLists(contactsData.data);
    
    $('#message-wrapper').on('keyup','.message_input',function (e) {
        if (e.which === 13) {
            return sendMessage(this);
        }
    });
    $('#search_input').on('keyup',function (e) {
        var s = $(this).val();
        if (e.which === 13 && s.length > 0) {
            $.ajax({
               url: '{{ route('chat.seach.contact') }}',
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
            $('#contacts-list-wrapper').html(contacts);
        }
    });
    
    
    
    $('#message-wrapper').on('click','.send_message',function(e){
        return sendMessage(this);
    	
    })
    
    $('#enduser-chat-list').on('click','.contact-item',function(e){
        socket.emit('send.contact.render',params);
        setTimeout(function(){
            socket.on('receive.contact.render',function(user){
                var temp = {
                      boxid: $(this).attr('data-mid'),
                      displayName: $(this).find('.media-heading').text(),
                      mid:  $(this).attr('data-mid'),
                      pictureUrl: $(this).find('img').attr('src'),
                };
                checkExistBoxItems(temp,function( $box ){
                    
                })
            })
        }), 1000
    });
    
});
</script>
@stop