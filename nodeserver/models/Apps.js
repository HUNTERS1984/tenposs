var mysql = require("mysql");
var config= require("./../config");
var connection = mysql.createConnection({
  host     : config.database.host,
  user     : config.database.user,
  password : config.database.password,
  database : config.database.database
});




    
exports.getAppInfo = function( chanel_id, callback ){
        
        var sql =   " SELECT * FROM apps WHERE bot_channel_id = ? LIMIT 1";
        connection.query({
            sql: sql,
                values: [chanel_id]
            }, function (error, results, fields) {
                if( error ) return false;
                callback(results[0]);
                return true;
            });
      
    }

