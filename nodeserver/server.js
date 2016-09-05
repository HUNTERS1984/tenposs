// Start redis: sudo service redis-server start
var app     = require('express')(),
    http    = require('http').Server(app),
    io      = require('socket.io')(http),
    Redis   = require('ioredis'),
    redis   = new Redis(8082);// Start redis on port 8082

// Models
var Messages = require("./models/Messages");


var port = 8081; // Start socket io port 8081
   
http.listen(port, function() {
    console.log('Listening on *:' + port);
});

io.on('connection', function (socket_client) {

    socket_client.on('join', function(user) {
        console.log('User connect:'+ JSON.stringify(user));
        console.log('----------------------------------------------------------');
        socket_client.room = user.channel;
        socket_client.user = user;
        socket_client.join(user.channel);
        
        var packageConnected = {
            user: user,
            message: user.profile.displayName +' connected!'
        };
        if( user.from == 'enduser' ){
            io.sockets.in(socket_client.room).emit('receive.admin.connected', packageConnected);
        }else{
            io.sockets.in(socket_client.room).emit('receive.user.connected', packageConnected);
        }
        
      
        //subscribe connected user to a specific channel, 
        //later he can receive message directly from our ChatController
        redis.subscribe(['line.message'], function (err, count) {});

        // get messages send by ChatController
        redis.on("message", function (channel, message) {
            console.log('Receive message %s from system in channel %s', message, channel);
            socket_client.emit(channel, message);
        });

        

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
    });
    
    socket_client.on('send.admin.message', function (package) {
        console.log('Receive message from admin ' + package.message + ' from user: ' + JSON.stringify(socket_client.user));
         var packageMessages = {
            user: socket_client.user,
            message: package
        };
        io.in(socket_client.room).clients(function (error, clients) {
            if (error) { throw error; }
            if( clients ){
                for( i in clients){
                    var client = io.sockets.sockets[clients[i]];
                    console.log('Emit to user:');
                    console.log(package);
                    console.log(client.user.profile.mid);
                    if( package.to == client.user.profile.mid ){
                        
                        client.emit('receive.user.message', packageMessages);
                    }
                }
            }
  
        });
        
  
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