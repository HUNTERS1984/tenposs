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
      <div class="panel panel-info">
        <div class="panel-heading">Tenposs <span id="status" style="color:red"></span></div>
        <div class="panel-body">
          <div id="" class="">
              <ul class="messages scrollbar-macosx"></ul>
          </div>
        </div>
        <div class="panel-footer">
          <div class="input-group">
              <input type="text" class="form-control message_input" placeholder="Enter message...">
              <span class="input-group-btn">
                  <button class="btn btn-default send_message" type="button">Send</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.min.js"></script>    
<script type="text/javascript">

var socket;
var profile = $.parseJSON('<?php echo ($profile) ?>');
var channel = '{{ $channel }}';

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
                if( profile.mid == package.messages[i].from_mid ){
                  drawMessage('right',profile,package.messages[i].message);
                }else{
                   drawMessage('left',package.to,package.messages[i].message);
                }
              }
            }
        });
        
        
    });
    
    socket.on('receive.user.message',function(package){
      console.log(package);
      drawMessage('left',package.user.profile,package.message.message);
    });
    
    socket.on('receive.bot.message',function(package){
      console.log('receive bot message');
      console.log(package);
      drawMessage('right',profile,package.message.message);
    });
    
    socket.on('receive.user.connected',function(package){
      $('span#status').text('Online');
      drawSystemMessage(package.message);
    });
    
    socket.on('receive.user.disconnect',function(package){
      $('span#status').text('Offline');
      drawSystemMessage(package.message);
    });
    
    socket.on('');
    return false;
}


function drawMessage(side, profile, message){
     
    var $message;
    var $messages = $('ul.messages');
    var d = new Date();
    $message = $($('.message_template').clone().html());
    $message.addClass(side).find('.text').html(message);
    $message.find('.avatar img').attr('src',profile.pictureUrl+'/small')
    $message.find('.timestamp').text( converTimestamp(d.getTime()/1000));
    $messages.append($message);
    setTimeout(function () {
        return $message.addClass('appeared');
    }, 0);
    return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
}

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
 

function sendMessage(text) {
    var $messages, message;
    if (text.trim() === '') {
        return;
    }
    $('.message_input').val('');
    $messages = $('ul.messages');
    drawMessage('right',profile, text);
    // Send message to server
    var d = new Date();
    var package = {
        'message': text,
        'timestamp': d.getTime()/1000
    };
    socket.emit('send.user.message',package);
    return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
};

function getMessageText() {
   return $('.message_input').val();
};

function converTimestamp(timestamp){
  var d = new Date(timestamp);
  return d.getHours()+'h:'+d.getMinutes()+'m:'+d.getSeconds()+'s '+d.getDay()+'-'+d.getMonth()+'-'+d.getUTCFullYear();
}

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