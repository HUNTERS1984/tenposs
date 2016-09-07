// Start redis: sudo service redis-server start
var app     = require('express')(),
    http    = require('http').Server(app),
    io      = require('socket.io')(http),
    Redis   = require('ioredis'),
    redis   = new Redis(8082),// Start redis on port 8082
    request = require('request');
    
// Models
const API_SEND_MESSAGE = 'https://trialbot-api.line.me/v1/events';


var Messages          = require("./models/Messages");
var LineAccounts      = require("./models/LineAccounts"); 
var Apps              = require("./models/Apps"); 
var Bot               = require("./line/Bot"); 


var port = 8081; // Start socket io port 8081
   
http.listen(port, function() {
    console.log('Listening on *:' + port);
});

io.on('connection', function (socket_client) {

    socket_client.on('join', function(user) {
        // Check user connect exist
        LineAccounts.checkExistAccounts( user, function( exitsUser ){
            if( !exitsUser ){
                console.log('LineAccounts not exits'); return;
            }else{
                
                console.log('User connected:'+ JSON.stringify(user));
                console.log('----------------------------------------------------------');
                socket_client.room = user.channel;
                socket_client.user = user;
                socket_client.join(user.channel);
                socket_client.to = exitsUser;
                
                var packageConnected = {
                    user: user,
                    message: user.profile.displayName +' connected!'
                };
                if( user.from === 'enduser' ){
                    console.log('1.Found client');
                    // Find client in room are online
                    findIsClientInRoom(socket_client.room, function( foundClient ){
                        console.log('2.Found client result:'+ JSON.stringify(foundClient) );
                        
                        if( foundClient ){
                            // Send connected message to client
                            io.sockets.in(socket_client.room).emit('receive.admin.connected', packageConnected);
                            Messages.getMessageHistory( foundClient.user.profile.mid, socket_client.user.profile.mid, 10, function( messages ){
                                var package = {
                                    messages: messages,
                                    to: foundClient.user.profile
                                };
                                socket_client.emit('history', package);
                            })
                        }else{
                            console.log('3. Not found client emit history: not client online');
                            Messages.getMessageHistory( exitsUser.bot_mid, socket_client.user.profile.mid, 10, function( messages ){
                                var package = {
                                    messages: messages,
                                    to: exitsUser
                                };
                                socket_client.emit('history', package);
                            })
                        }
                    });
                    
                    
                }else{
                    
                    
                    io.sockets.in(socket_client.room).emit('receive.user.connected', packageConnected);
                    
                    
                }
                
                //subscribe connected user to a specific channel, 
                //later he can receive message directly from our ChatController
                redis.subscribe(['message.bot'], function (err, count) {
                    console.log(count);
                });
                
                // get messages send by ChatController
                redis.on("message.bot", function (channel, message) {
                    console.log('Receive message %s from system in channel %s', message, channel);
                    socket_client.emit(channel, message);
                });
                
            }
        }) ;
           
        
        
        

    });
    
    // get user sent message and broadcast to all connected users
    socket_client.on('send.user.message', function (package) {
       // console.log('Receive message ' + package.message + ' from user: ' + JSON.stringify(socket_client.user));
         var packageMessages = {
            user: socket_client.user,
            message: package
        };
        console.log("send package to admin ");
        console.log( packageMessages );
        io.sockets.in(socket_client.room).emit('receive.admin.message', packageMessages);
        
        
      
        Apps.getAppInfo(socket_client.room,function( appinfo ){
            console.log('Appinfo');
            console.log(appinfo);
            if(appinfo){
                Bot.sendTextMessage(
                     appinfo,
                     socket_client.user.profile.mid.split(),
                     '1383378250',
                     '138311608800106203',
                     package.message,function(result){
                        console.log(result);
                    }
                );
            }
        });
    });
    
    socket_client.on('send.admin.message', function (package) {
        console.log('Receive message from admin ' + package.message + ' from user: ' + JSON.stringify(socket_client.user));
         var packageMessages = {
            user: socket_client.user,
            message: package
        };
        
        findClientInRoomByMid( socket_client.room, package.to, function( client ){
            if( client ){
                client.emit('receive.user.message', packageMessages);
                Apps.getAppInfo(socket_client.room,function( appinfo ){
                    console.log('Appinfo');
                    console.log(appinfo);
                    if(appinfo){
                        Bot.sendTextMessage(
                             appinfo,
                             client.user.profile.mid.split(),
                             '1383378250',
                             '138311608800106203',
                             package.message,function(result){
                                console.log(result);
                            }
                        );
                    }
                });
            }
        } );
        
 
    });
    
    socket_client.on('disconnect', function() {
        var package = {
            user: socket_client.user,
            message: socket_client.user.profile.displayName +' disconnected!'
        };
        if( socket_client.user.from == 'enduser' )
            io.sockets.in(socket_client.room).emit('receive.admin.disconnect',package );
        else{
            io.sockets.in(socket_client.room).emit('receive.user.disconnect', package );
        }
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