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

var userType = ['client','enduser'];
   
http.listen(port, function() {
    console.log('Listening on *:' + port);
});

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
                        socket.to = exitsUser;
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
                                Messages.getMessageHistory( exitsUser.bot_mid, socket.user.profile.mid, 10, function( messages ){
                                    var package = {
                                        messages: messages,
                                        to: exitsUser
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
                        var count = 0;
                        for( var i in arrMids ){
                            if( arrMids[i] !== socket.user.profile.mid ){
                                count++;
                                Messages.getMessageClientHistory('uaa357d613605ebf36f6366a7ce896180',socket.user.profile.mid,arrMids[i],20, function(data){
                                    console.log('return data history: '+arrMids[i]);
                                    var temp = {
                                        mid: arrMids[i],
                                        history: data
                                    }
                                   
                                    packageHistory.push(temp);
                                    console.log(packageHistory);
                                    console.log( 'i:'+(arrMids.length - 1)+'count:'+count );
                                    
                                    if( count == (arrMids.length - 1) ){
                                        socket.emit('history',packageHistory);
                                    }
                                    
                                } );
                                
                               
                            }
                            
                        }
                        
                        
                    }
                    
                } );
                    
                io.sockets.in(socket.room).emit('receive.user.connected', packageConnected);
            }
                
            //subscribe connected user to a specific channel, 
            //later he can receive message directly from our ChatController
            redis.subscribe(['message.bot'], function (err, count) {
                console.log(count);
            });
            
            // get messages send by ChatController
            redis.on("message.bot", function (channel, message) {
                console.log('Receive message %s from system in channel %s', message, channel);
                socket.emit(channel, message);
            });
            
        }
        


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