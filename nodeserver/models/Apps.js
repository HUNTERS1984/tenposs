var mysql = require("mysql");
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'phanvannhien',
  password : '',
  database : 'c9'
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

