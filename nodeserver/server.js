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
        socket_client.room = user.channel;
        socket_client.data = user;
        socket_client.join(user.channel);
        
        
        
        
        console.log(socket_client);
        //subscribe connected user to a specific channel, 
        //later he can receive message directly from our ChatController
        redis.subscribe(['line.message'], function (err, count) {});

        // get messages send by ChatController
        redis.on("message", function (channel, message) {
            console.log('Receive message %s from system in channel %s', message, channel);
            socket_client.emit(channel, message);
        });


        // get user sent message and broadcast to all connected users
        socket_client.on('chat.send.message', function (message) {
            console.log('Receive message ' + message.msg + ' from user in channel chat.message');
            io.sockets.emit('chat.message', JSON.stringify(message));
        });


        socket_client.on('disconnect', function() {

        });

    });
});