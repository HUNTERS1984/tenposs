var https   = require('https'),     
    fs      = require('fs'),
    express = require('express'),
    app     = express();

var options = {
    key:    fs.readFileSync('/etc/apache2/ssl/ten-po.key'),
    cert:   fs.readFileSync('/etc/apache2/ssl/ten-po.crt'),
    ca:     fs.readFileSync('/etc/apache2/ssl/ten-po-ca.crt')
};

var server  = https.createServer(options, app),
    io      = require('socket.io')(server),
    redis   = require('ioredis'),
    request = require('request'),
    config  = require("./config");
    
    
server.listen(3000, function(){
    console.log('Server up and running at: 3000');
});

// Models
const API_SEND_MESSAGE = 'https://trialbot-api.line.me/v1/events';
var BOT_MID="uaa357d613605ebf36f6366a7ce896180";
var Messages          = require("./models/Messages");
var LineAccounts      = require("./models/LineAccounts"); 
var Apps              = require("./models/Apps"); 
var Bot               = require("./line/Bot"); 


var userType = ['client','enduser'];
var toUser = {
    bot_mid:        config.bot.BOT_MID,
    pictureUrl:     config.bot.BOT_PICTURE_URL,
    statusMessage:  config.bot.BOT_STATUS_MESSAGE,
    displayName:    config.bot.BOT_DISPLAY_NAME
};


io.on('connection', function (socket) {

    socket.on('join', function(user) {

        
        // Check user type connect is exist
        if( userType.indexOf(user.from) === -1 ){
            console.log('Error: Not found user type connect');
            return;
        }else{
            var packageConnected = {
                user: user,
                message: user.profile.displayName +' connected!'
            };
            console.log('Info: User connected: '+ JSON.stringify(user));
            console.log('----------------------------------------------------------');
            if( user.from === 'enduser' ){// is enduser
                LineAccounts.checkExistAccounts( user, function( exitsUser ){
                    if( !exitsUser ){
                        console.log('Error: Enduser LineAccounts not exits'); return;
                    }else{
                        
                        
                        socket.room = user.channel;
                        socket.user = user;
                        socket.join(user.channel);
                        socket.to = toUser;
                         // Find client in room are online
                        findIsClientInRoom(socket.room, function( foundClient ){
                           
                            if( foundClient ){
                                // Send connected message to client
                                io.sockets.in(socket.room).emit('receive.admin.connected', packageConnected);
                                Messages.getMessageHistory( foundClient.user.profile.mid, socket.user.profile.mid, 10, function( messages ){
                                    var package = {
                                        messages: messages,
                                        to: foundClient.user.profile
                                    };
                                    socket.emit('history', package);
                                    var packageConnected = {
                                        user: foundClient.user,
                                        message: foundClient.user.profile.displayName +' online!'
                                    };
                                    socket.emit('receive.user.connected', packageConnected);
                                })
                            }else{
                                console.log('Info: Not found client emit history: not client online');
                                Messages.getMessageHistory( toUser.bot_mid, socket.user.profile.mid, 10, function( messages ){
                                    var package = {
                                        messages: messages,
                                        to: toUser
                                    };
                                    socket.emit('history', package);
                                })
                            }
                        });
                        
                        
                        
                    }
                }) ;
           
            }else{ // is client
                socket.room = user.channel;
                socket.user = user;
                socket.join(user.channel);
                
                var packageHistory = [];
                getEnduserMidsOnlineInRoom( user.channel, function(arrMids){
                    console.log('Array enduser connect'+ JSON.stringify(arrMids) );
                    
                    if( arrMids.length > 0 ){
                       
                        removeItemArray(arrMids,socket.user.profile.mid, function(newArr){
                            var count = 0;
                            for( var i in newArr ){
                                if( arrMids[i] !== socket.user.profile.mid ){
                                    count++;
                                    Messages.getMessageClientHistory(socket.room,socket.user.profile.mid,arrMids[i],20, function(data){
                                        console.log('return data history: '+arrMids[i]);
                                        var temp = {
                                            mid: arrMids[i],
                                            history: data
                                        }
                                       
                                        packageHistory.push(temp);
                                        console.log(packageHistory);
                                        console.log( 'i:'+(arrMids.length - 1)+'count:'+count );
                                        
                                        if( count == (arrMids.length) ){
                                            socket.emit('history',packageHistory);
                                        }
                                        
                                    } );
                                    
                                }else{
                                    
                                }
                            }
                        });
                        
                       
                    }
                    
                } );
                    
                io.sockets.in(socket.room).emit('receive.user.connected', packageConnected);
            }
                
        }
        
        socket.on('disconnect', function() {
            var package = {
                user: socket.user,
                message: socket.user.profile.displayName +' disconnected!'
            };
            if( socket.user.from == 'enduser' )
                io.sockets.in(socket.room).emit('receive.admin.disconnect',package );
            else{
                io.sockets.in(socket.room).emit('receive.user.disconnect', package );
            }
        });
        
        
        var redisClient = redis.createClient();

        //subscribe connected user to a specific channel, 
        //later he can receive message directly from our ChatController
        redisClient.subscribe('message.bot');
        
        
        // get messages send by ChatController
        redisClient.on("message.bot", function (channel, message) {
            console.log('--------------------- Rediss ---------------');
            console.log('Receive message %s from system in channel %s', message, channel);
            socket.emit(channel, message);
        });

    });
    
    // get user sent message and broadcast to all connected users
    socket.on('send.user.message', function (package) {
       // console.log('Receive message ' + package.message + ' from user: ' + JSON.stringify(socket.user));
         var packageMessages = {
            user: socket.user,
            message: package
        };
        console.log("send package to admin ");
        console.log( packageMessages );
        
        // Find client inroom
        Messages.saveMessage(socket.room, socket.user.profile.mid, BOT_MID, package.message, function(inserID){
           console.log('Save message success');
        });
        
   
        io.sockets.in(socket.room).emit('receive.admin.message', packageMessages);
        
        Bot.sendTextMessage(
             socket.user.profile.mid.split(),
             package.message,function(result){
                console.log(result);
            }
        );
            
    });
    
    socket.on('send.admin.message', function (package) {
        console.log('Receive message from admin ' + package.message + ' from user: ' + JSON.stringify(socket.user));
         var packageMessages = {
            user: socket.user,
            message: package
        };
        
         // Find client inroom
        Messages.saveMessage(socket.room, BOT_MID, package.to, package.message, function(inserID){
           console.log('Save admin message success');
        });
        
        findClientInRoomByMid( socket.room, package.to, function( client ){
            if( client ){
                client.emit('receive.user.message', packageMessages);
                
                Bot.sendTextMessage(
                     client.user.profile.mid.split(),
                     package.message,function(result){
                        console.log(result);
                    }
                );
                    
            }
        } );
        
 
    });
    
    
    
});

function findClientInRoomByMid( room_id, mid , _callback){
    
    io.in(room_id).clients(function (error, clients) {
            if (error) { _callback(false) }
            if( clients ){
                for( var i in clients){
                    var client = io.sockets.sockets[clients[i]];
                    if( mid == client.user.profile.mid ){
                        _callback(client);
                        break;
                    }
                }
            }
    });
}

function findIsClientInRoom( room_id, _callback ){
     io.in(room_id).clients(function (error, clients) {
            if (error) { 
                console.log(error);
                return _callback(false) ;
            }
            if( clients ){
                
                var count = 0;
                for( var i in clients){
                    count++;
                    var client = io.sockets.sockets[clients[i]];
                    if( 'client' === client.user.from ){
                        return _callback(client);
                        break;
                    }else{
                         
                        if( count === clients.length ){
                            return _callback(false);
                        }
                    }
                }
            }
    });
}

function getEnduserMidsOnlineInRoom(room_id, _callback){
    // Get all enduser are connecting
    io.in(room_id).clients(function (error, endusers) {
        if (error) { console.log('Error:'+error);return; }
        if( endusers ){
            var arrMids = [], count = 0;
            for( var i in endusers){
                count++;
                var enduser = io.sockets.sockets[endusers[i]];
                arrMids.push(enduser.user.profile.mid);
                if( count === endusers.length )
                    return _callback(arrMids);
            }
        }
    });
}


function removeItemArray(arr, val,_callback) {
  var j = 0;
  for (var i = 0, l = arr.length; i < l; i++) {
    if (arr[i] !== val) {
      arr[j++] = arr[i];
    }
  }
  arr.length = j;
  _callback(arr);
}