var request = require('request');


var API_EVENTS = 'https://trialbot-api.line.me/v1/events';
var TO_CHANEL = '1383378250';
var EVENT_TYPE = '138311608800106203';

    
exports.sendTextMessage =  function(app, to, toChannel,eventType, message,_callback){
       
        
        var body = {
            'to':to, 
            'toChannel':toChannel ,
            'eventType':eventType,
            'content':{
                'contentType':'1',
                'toType':'1',
                'text':message
            }
            
        };
        var options = {
            uri: API_EVENTS,
            method: 'POST',
            headers: {
                "content-type": "application/json; charser=UTF-8",
                'X-Line-ChannelID': app.bot_channel_id,
                'X-Line-ChannelSecret': app.bot_channel_secret,
                'X-Line-Trusted-User-With-ACL': app.bot_mid,
            },
            json: true,
            body: body
        };
        
        request(options,function(error, response, body){
            if (!error && response.statusCode == 200) {
                return _callback(body);  
            }else{
                return false;
            }
        });
        
            
    }