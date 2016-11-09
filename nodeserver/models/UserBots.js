var mysql = require("mysql");
var config= require("./../config");

var mysqlConfig = {
  host     : config.database.host,
  user     : config.database.user,
  password : config.database.password,
  database : config.database.database
};
var connection;

exports.getBot = function(chanel_id, _callback){
    
        var sql =   " SELECT * "+
                	" FROM user_bots "+
                	" WHERE user_bots.chanel_id = ? LIMIT 1";

        connection = mysql.createConnection(mysqlConfig);
        connection.connect();       	
        var query = connection.query({
            sql: sql,
                values: [chanel_id]
            }, function (error, results, fields) {
                console.log(query.sql);
                if(error){
                    connection.end();
                    return false;
                }else{
                    connection.end();
                    return _callback(results);
                }
            });
        
    }
