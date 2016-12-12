<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Enduser Chat</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ secure_asset('assets/css/chat.css') }} "/>
  </head>
  <body>
    <div class="container">
      <p>&nbsp;</p>  
      <div class="panel panel-info" style="border-color: white;">
        <div class="panel-body">
          <div id="" class="">
              <ul class="messages scrollbar-macosx"></ul>
          </div>
        </div>
        <div class="panel-footer" style="border-top: 0px; padding: 0px;">
          <div class="input-group input-message">
              <input type="text" class="form-control message_input" placeholder="メッセージを入力してください...">
              <span class="input-group-btn input-group-addon">
                  <a class="send_message">送信</a>
              </span>
          </div><!-- /input-group -->
        </div>
      </div><!--end panel --> 
      <div class="message_template" style="display:none">
          <li class="message">
              <div class="avatar">
                <img src=""/>
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
      
      
    </div><!--end container -->
    
<script type="text/javascript" src="{{ secure_asset('assets/js/jquery-1.11.2.min.js') }} "></script>
<script type="text/javascript" src="{{ secure_asset('assets/plugins/jquery.scrollbar/jquery.scrollbar.min.js') }} "></script>
<script src="{{ secure_asset('assets/js/socket.io.min.js') }}"></script>
<script src="{{ secure_asset('assets/js/moment.min.js') }}"></script>
<script type="text/javascript">

var socket;
var profile = $.parseJSON('<?php echo ($profile) ?>');
var channel = '{{ $channel }}';

// Connect to server 
function connectToChat() {
    socket = new io.connect("{{ config('line.CHAT_SERVER') }}", {
        'reconnection': true,
        'reconnectionDelay': 1000,
        'reconnectionDelayMax' : 5000,
        'reconnectionAttempts': 5
    });

    socket.on('connect', function (user) {
        console.log('Request connect');
        var package = {
            from: 'enduser',
            channel: channel,
            profile: profile
        }
        socket.emit('join', package);
        
        socket.on('history', function( package ){
          console.log('History');
          console.log(package);
            if( package.messages ){
              for( var i in package.messages ){
                drawMessage({
                  text: package.messages[i].message,
                  timestamp: moment( parseInt(package.messages[i].created_at) ).format() ,
                  profile: (function(id){
                    if( profile.mid === id ){
                      return profile;
                    }else{
                      return package.to;
                    }
                  })( package.messages[i].from_mid )
                });
               
              }
            }
        });
        
        
    });
    /**
     *  package : {
     *       text: string,
     *       timestamp: string,
     *       profile: profile
     *   }
     */
    socket.on('receive.user.message',function(package){
      console.log('Receive client message');
      console.log(package);
      drawMessage(package);
    });
    
    /**
     *  package : {
     *       text: string,
     *       timestamp: string,
     *       profile: profile
     *   }
     */
    socket.on('receive.bot.message',function(package){
      console.log('Receive bot message');
      console.log(package);
      drawMessage(package);
    });
    /**
     * {
     *    user: user,
     *    message: string
     * }
     */
    socket.on('receive.user.connected',function(package){
      $('span#status').text('Online');
      drawSystemMessage(package.message);
    });
    /**
     * {
     *    user: user,
     *    message: string
     * }
     */
    socket.on('receive.user.disconnect',function(package){
      $('span#status').text('Offline');
      drawSystemMessage(package.message);
    });
    return false;
}

/*
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
    
    var d = new Date();
  	var side = 'left';
  	if( message.profile.mid == profile.mid ){
  	    side = 'right';
  	    profileTemp = profile;
  	}
    $messages = $('ul.messages');
    $message = $($('.message_template').clone().html());
    $message.addClass(side).find('.text').html(message.text);
    $message.find('.avatar img').attr('src',profileTemp.pictureUrl+'/small')
    $message.find('.timestamp').text( moment(message.timestamp).format('LTS') );
    $messages.append($message);
    $message.addClass('appeared');
    return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
}

/**
 * text: string
 */ 


function drawSystemMessage(text){
  var $messages = $('ul.messages');
  var $message = $($('.message_template_system').clone().html());
  $message.find('p').text(text);
  $messages.append($message);
  setTimeout(function () {
      return $messages.addClass('appeared');
  }, 0);
  return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
}
 
/**
 * text: string
 */ 
function sendMessage(text) {
    if (text.trim() === '') {
        return false;
    }
    var d = new Date();
    var $messages = $('ul.messages');
    $('.message_input').val('');

    drawMessage({
        text: text,
        timestamp: d.getTime(),
        profile: profile
    });
    // Send message to server
    socket.emit('send.user.message',{
        'message': text,
        'timestamp': d.getTime()
    });
    return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
};

/**
 * @return string
 */ 
function getMessageText() {
   return $('.message_input').val();
};


$(document).ready(function(){
    connectToChat();
    jQuery('.scrollbar-macosx').scrollbar();
    $('.send_message').click(function (e) {
        e.preventDefault();
        return sendMessage(getMessageText());
    });
    $('.message_input').keyup(function (e) {
        if (e.which === 13) {
            return sendMessage(getMessageText());
        }
    });
    
});
</script>
</body>
</html>