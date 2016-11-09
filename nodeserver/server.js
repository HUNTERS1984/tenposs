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
    
    

const API_SEND_MESSAGE  = 'https://trialbot-api.line.me/v1/events';
// Models
var Messages            = require("./models/Messages");
var LineAccounts        = require("./models/LineAccounts"); 
var Apps                = require("./models/Apps"); 
var Bot                 = require("./line/Bot"); 
var UserBots            = require("./models/UserBots");

var userType = ['client','enduser'];
// Log
log4js.loadAppender('file');
log4js.addAppender(log4js.appenders.file('logs/chat.log'), 'chat');
var logger = log4js.getLogger('chat');
logger.setLevel('TRACE');

server.listen(3000, function(){
    logger.trace('Server up and running at: 3000');
});


var redisClient = redis.createClient();
redisClient.subscribe('message');

/*
{"result":[
    {
        "from":"u2ddf2eb3c959e561f6c9fa2ea732e7eb8",
        "fromChannel":1341301815,
        "to":["u0cc15697597f61dd8b01cea8b027050e"],
        "toChannel":1441301333,
        "eventType":"138311609000106303",
        "id":"ABCDEF-12345678901",
        "content": {
            "location":null,
            "id":"325708",
            "contentType":1,
            "from":"uff2aec188e58752ee1fb0f9507c6529a",
            "createdTime":1332394961610,
            "to":["u0a556cffd4da0dd89c94fb36e36e1cdc"],
            "toType":1,
            "contentMetadata":null,
            "text":"Hello, BOT API Server!"
        }
    },
  ...
]}
*/
// Redis

/*
redisClient.on("message", function (channel, message) {
    logger.trace('Redis ------------------------------------------------');
    logger.info('Redis receive message: ', message, channel);
    message = JSON.parse(message);
    // Find from is online
    findClientInRoomByMid(message.channel,message.data.content.from, 
        function( fromUser ){
        if( fromUser ){
            // Emit to from user
            fromUser.emit('receive.bot.message',{
                text: message.data.content.text,
                timestamp: message.data.content.createdTime,
                profile: fromUser.user.profile
            });
        }
        
    });
    
    // Find to is online
    findClientInRoomByMid(
        message.channel,message.data.content.to, 
        function( toUser ){
            if( toUser ){
                LineAccounts.checkExistAccounts( {
                    from: 'enduser',
                    profile: {
                        mid: message.data.content.from
                    }
                },  function( exitsUser ){
                        if( !exitsUser ){
                            logger.warn('Enduser LineAccounts not exits'); return;
                        }else{
                            toUser.emit('receive.admin.message', {
                                windows : {
                                    mid: exitsUser.mid,
                                    displayName: exitsUser.displayName
                                },
                                message: {
                                    text: message.data.content.text,
                                    timestamp: message.data.content.createdTime,
                                    profile: {
                                        mid: exitsUser.mid,
                                        displayName: exitsUser.displayName,
                                        pictureUrl: exitsUser.pictureUrl
                                    }
                                }
                            }); 
                        };
                    }
                );
            };
        }
    );
    
    Messages.saveMessage(message.channel, message.data.content.from, BOT_MID, message.data.content.text, function(inserID){
        logger.info('Save message BOT success');
    });

});
*/

io.on('connection', function (socket) {
      
    socket.on('join', function(user) {
        // Check user type connect is exist
        if( userType.indexOf(user.from) === -1 ){
            logger.warn('Not found user type connect');
            return;
        }else{
            // Save info to socket
            socket.room = user.channel;
            socket.user = user;
            socket.join(user.channel);
            
            // Package user connected status
            var packageConnected = {
                user: user,
                message: user.profile.displayName +' connected!'
            };
            
            
            if( user.from === 'client' ){
                var packageHistory = [];
                // find all enduser are connected 
                getEnduserMidsOnlineInRoom( socket.room, function(arrMids){
                    logger.info('All are connected'+ JSON.stringify(arrMids) );
                    
                    if( arrMids.length > 0 ){
                        removeItemArray(arrMids,{
                                mid: socket.user.profile.mid, 
                                displayName:  socket.user.profile.displayName
                            },
                            function(newArr){
                                
                                /*
                                var count = 0;
                                for( var i in newArr ){
                                    if( arrMids[i].mid !== socket.user.profile.mid ){
                                        count++;
                                        Messages.getMessageClientHistory(
                                            socket.room,socket.user.profile.mid,
                                            arrMids[i].mid,20, 
                                            function(data){
                                                
                                                var temp = {
                                                    windows: newArr[i],
                                                    history: data
                                                }
                                                logger.trace('History message client');
                                                logger.info(temp);
                                                packageHistory.push(temp);
                    
                                                if( count == (arrMids.length) ){
                                                    // Emit to client data history
                                                    socket.emit('history',packageHistory);
                                                }
                                                
                                            }
                                        );
                                        
                                    }
                                }
                                */
                            // Emit list to client, enduser online
                            socket.emit('receive.admin.getClientOnline',newArr);
                        });

                    }
                    
                } );
                // Emit to enduser, client connected    
                io.sockets.in(socket.room).emit('receive.user.connected', packageConnected);
                            
            }else{
                
                // check exist account
                LineAccounts.checkExistAccounts( user, 
                    function( exitsUser ){
                        if( !exitsUser ){
                            logger.warn('Enduser LineAccounts not exits'); return;
                        }else{
                            logger.info('Enduser connected: '+ JSON.stringify(user));
                            UserBots.getBot( socket.room, function( userbot ) {
                                if(userbot){
                                    Bot.getProfileByToken(userbot.chanel_access_token, function( botprofile ){
                                        if( botprofile ){
                                            socket.toUser = botprofile;
                                            // Find client in room are online
                                            findIsClientInRoom(socket.room, 
                                                function( foundClient ){
                                                    if( foundClient ){
                                                        // Send to client, enduser connected message
                                                        io.sockets.in(socket.room).emit('receive.admin.connected', packageConnected);
                                                        Messages.getMessageHistory( 
                                                            foundClient.user.profile.mid, 
                                                            socket.user.profile.mid, 10, 
                                                            function( messages ){
                                                                // Emit to client history message
                                                                var package = {
                                                                    messages: messages,
                                                                    to: foundClient.user.profile
                                                                };
                                                                socket.emit('history', package);
                                                                // Emit to enduser client are online
                                                                var packageConnected = {
                                                                    user: foundClient.user,
                                                                    message: foundClient.user.profile.displayName +' online!'
                                                                };
                                                                socket.emit('receive.user.connected', packageConnected);
                                                            }
                                                        )
                                                    }else{
                                                        logger.info('Not found client are online');
                                                        // Emit to enduser message history
                                                        Messages.getMessageHistory( 
                                                            socket.toUser.mid, 
                                                            socket.user.profile.mid, 10, 
                                                            function( messages ){
                                                                var package = {
                                                                    messages: messages,
                                                                    to: socket.toUser
                                                                };
                                                                socket.emit('history', package);
                                                            }
                                                        )
                                                    }// endif
                                             });
                                        }else{
                                            return;
                                        }
                                    })
                                    
                                }else{
                                    return;
                                }
                            } );
                
                        }
                }) ;
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
    
    /**
     * mid: string
     * 
     */ 
    socket.on('admin.send.history',function(mid){
        LineAccounts.checkExistAccounts( {
                from: 'enduser',
                profile: {
                    mid: mid
                }
            }, 
            function( exitsUser ){
                if( !exitsUser ){
                    logger.warn('Enduser LineAccounts not exits'); return;
                }else{
                    Messages.getMessageHistory(
                        socket.user.profile.mid, 
                        mid, 
                        10, function( messages ){
                            logger.info( messages );
                            socket.emit('receive.admin.history',  {
                                history: messages,
                                windows: {
                                    mid: exitsUser.mid,
                                    displayName: exitsUser.displayName,
                                    pictureUrl: exitsUser.pictureUrl
                                }
                            });
                        })
                }
                
        });
        
        
    });
    
    
    
    // handle message from endusers
    /**
     *  package = {
     *       'message': string,
     *       'timestamp': timestamp
     *  }   
     * 
     */
    
    socket.on('send.user.message', function (package) {
    
        var packageMessages = {
            windows: {
                mid: socket.user.profile.mid,
                displayName: socket.user.profile.displayName
            },
            message: {
                text: package.message,
                timestamp: package.timestamp,
                profile: socket.user.profile
            }
        };
        logger.info("Send package to clients");
        logger.info( packageMessages );
        
        // Save message
        Messages.saveMessage(
            socket.room, 
            socket.user.profile.mid, 
            socket.toUser.mid, package.message, 
            function(inserID){
                logger.info('Save message success');
            }
        );
        
        // Emit to clients
        io.sockets.in(socket.room).emit('receive.admin.message', packageMessages);
        
        /*
        Bot.sendTextMessage(
             socket.user.profile.mid.split(),
             package.message,function(result){
                logger.info(result);
            }
        );
        */    
    });
    
    
    // handle message from clients
    /**
     *  package : {
     *       to: string,
     *       message: string,
     *       timestamp
     *   }
     */
    socket.on('send.admin.message', function (package) {
 
        var packageMessages = {
            text: package.message,
            timestamp: package.timestamp,
            profile: socket.user.profile
        };
        
        // Find if enduser online
        findClientInRoomByMid( socket.room, package.to, function( client ){
            if( client ){
                client.emit('receive.user.message', packageMessages);
            }
        } );
        
        // Save messages
        Messages.saveMessage(socket.room, package.from, package.to, package.message, function(insertID){
           logger.info('Save admin message success');
        });
        
        Bot.sendTextMessage(
             package.to.split(),
             package.message,function(result){
                console.log(result);
            }
        );
 
    });
    
    
});


/*
* room_id:      string
* mid:          string mid to find        
* @return :     callback function socket client found, false is not found
*/
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


/*
* room_id:      string
* @return :     callback function socket found is client, false not found
*/
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


/*
* room_id:      string
* @return :     array[{mid: string, displayName: string}]
*/
function getEnduserMidsOnlineInRoom(room_id, _callback){
    // Get all enduser are connecting
    io.in(room_id).clients(function (error, endusers) {
        if (error) { console.log('Error:'+error);return; }
        if( endusers ){
            var arrMids = [], count = 0;
            for( var i in endusers){
                count++;
                var enduser = io.sockets.sockets[endusers[i]];
                arrMids.push({mid: enduser.user.profile.mid, displayName: enduser.user.profile.displayName} );
                if( count === endusers.length )
                    return _callback(arrMids);
            }
        }
    });
}

/*
* arr:      array
* val:      string to remove
* Return:   array   
*/

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