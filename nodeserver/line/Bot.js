var request = require('request');
var UserBots            = require("./../models/UserBots"),
    config              = require("./../config");



var BOT_CHANEL_ID="1476076743";
var BOT_MID="uaa357d613605ebf36f6366a7ce896180";
var BOT_CHANEL_SECRET="c3b5f65446faefcf1471609353cc943c";
var BOT_DISPLAY_NAME="TenPoss";
var BOT_PICTURE_URL="http://dl.profile.line-cdn.net//0m019bee3d7251ef5a2c3a7b22a7e66b703af19dd176f2";	
var BOT_STATUS_MESSAGE="Welcome";

var API_EVENTS = 'https://trialbot-api.line.me/v1/events';
var API_BOT_PROFILE = 'https://api.line.me/v1/profile';
var TO_CHANEL = '1383378250';
var EVENT_TYPE = '138311608800106203';



exports.getProfileByToken = function( token, _callback ){
    var body = {};
    var options = {
        uri: API_BOT_PROFILE,
        method: 'GET',
        headers: {
            "Authorization": "Bearer "+token,
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

exports.sendTextMessage =  function(to, message,_callback){
             
        var body = {
            'to':to, 
            'toChannel':TO_CHANEL ,
            'eventType':EVENT_TYPE,
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
                'X-Line-ChannelID': BOT_CHANEL_ID,
                'X-Line-ChannelSecret': BOT_CHANEL_SECRET,
                'X-Line-Trusted-User-With-ACL': BOT_MID,
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
    
exports.BOTSendMessage = function(chanel,to,message, _callback){
    
    UserBots.getBot( chanel, function( userbot ) {
        
        var body = {
            'to':to, 
            'messages':{
                "type": "text",
                "text": message
            }
        };
        var options = {
            uri: 'https://api.line.me/v2/bot/message/push',
            method: 'POST',
            headers: {
                "Authorization": "Bearer "+ userbot.chanel_access_token,
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
        
    });
    

        
}    