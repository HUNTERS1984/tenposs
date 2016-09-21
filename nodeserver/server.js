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
    config  = require("./config"),
    log4js  = require('log4js');
    
    
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


log4js.loadAppender('file');
log4js.addAppender(log4js.appenders.file('logs/chat.log'), 'chat');
var logger = log4js.getLogger('chat');
logger.setLevel('TRACE');

server.listen(3000, function(){
    logger.trace('Server up and running at: 3000');
});


var redisClient = redis.createClient();
redisClient.subscribe('message');
// get messages send by ChatController
redisClient.on("message", function (channel, message) {
    logger.trace('--------------------- Rediss -------------------------------');
    logger.info('Receive message %s from system in channel %s', message, channel);
    message = JSON.parse(message);
    // Find from is online
    findClientInRoomByMid(message.channel,message.data.content.from, function( fromUser ){
        if( fromUser ){
            var packageMessages = {
                user: fromUser.user,
                message: {
                    message: message.data.content.text,
                    timestamp: message.data.content.createdTime
                }
            };
            fromUser.emit('receive.bot.message',packageMessages);
            
            // Find to is online
            findClientInRoomByMid(message.channel,message.data.content.to, function( toUser ){
                 if( toUser ){
                     toUser.emit('receive.admin.message', packageMessages);
                 }
            });
            
        }else{// From User not Online
            var findUserInfo = {
                profile:{
                    mid: message.data.content.from
                }
            };
            LineAccounts.checkExistAccounts( findUserInfo, function( exitsUser ){
                if( !exitsUser ){
                    logger.warn('Enduser LineAccounts not exits'); return;
                }else{
                    // check to User is online
                    findClientInRoomByMid(message.channel,message.data.content.to, function( toUser ){
                        if(toUser){
                            toUser.emit('receive.admin.message', {
                                user: {
                                    profile:{
                                        mid: exitsUser.mid,
                                        pictureUrl: exitsUser.pictureUrl,
                                        displayName: exitsUser.displayName,
                                        statusMessage: exitsUser.statusMessage
                                    }
                                },
                                message: {
                                    message: message.data.content.text,
                                    timestamp: message.data.content.createdTime
                                }
                            });
                        }
                        
                    });
      
                }
            });
        }
        
        
    });
    Messages.saveMessage(message.channel, message.data.content.from, BOT_MID, message.data.content.text, function(inserID){
        logger.info('Save message BOT success');
    });

});






io.on('connection', function (socket) {
      
    socket.on('join', function(user) {
        // Check user type connect is exist
        if( userType.indexOf(user.from) === -1 ){
            logger.warn('Not found user type connect');
            return;
        }else{
            var packageConnected = {
                user: user,
                message: user.profile.displayName +' connected!'
            };
            logger.info('User connected: '+ JSON.stringify(user));
            if( user.from === 'enduser' ){// is enduser
                LineAccounts.checkExistAccounts( user, function( exitsUser ){
                    if( !exitsUser ){
                        logger.warn('Enduser LineAccounts not exits'); return;
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
                                logger.info('Not found client emit history: not client online');
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
                            socket.emit('receive.admin.getClientOnline',newArr);
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
        
        
        

    });
    
    socket.on('admin.send.history',function(mid){
        Messages.getMessageHistory( mid, socket.user.profile.mid, 10, function( messages ){
            var package = {
                history: messages,
                to: mid
            };
            socket.emit('receive.admin.history', package);
        })
    });
    
    // get user sent message and broadcast to all connected users
    socket.on('send.user.message', function (package) {
       // console.log('Receive message ' + package.message + ' from user: ' + JSON.stringify(socket.user));
         var packageMessages = {
            user: socket.user,
            message: package
        };
        logger.info("send package to admin ");
        logger.info( packageMessages );
        
        // Find client inroom
        Messages.saveMessage(socket.room, socket.user.profile.mid, BOT_MID, package.message, function(inserID){
           logger.info('Save message success');
        });
        
   
        io.sockets.in(socket.room).emit('receive.admin.message', packageMessages);
        
        Bot.sendTextMessage(
             socket.user.profile.mid.split(),
             package.message,function(result){
                logger.info(result);
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
           logger.info('Save admin message success');
        });
        
        findClientInRoomByMid( socket.room, package.to, function( client ){
            if( client ){
                client.emit('receive.user.message', packageMessages);
            }
        } );
        
        Bot.sendTextMessage(
             package.to.split(),
             package.message,function(result){
                console.log(result);
            }
        );
 
    });
    
    
});

function findClientInRoomByMid( room_id, mid , _callback){
    
    io.in(room_id).clients(function (error, clients) {
            if (error) { _callback(false) }
            if( clients ){
                var count = 0;
                for( var i in clients){
                    count++;
                    var client = io.sockets.sockets[clients[i]];
                    if( mid == client.user.profile.mid ){
                        _callback(client);
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