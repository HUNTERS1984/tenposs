var mysql = require("mysql");
var config= require("./../config");

var mysqlConfig = {
  host     : config.database.host,
  user     : config.database.user,
  password : config.database.password,
  database : config.database.database
};
var connection;


exports.checkExistAccounts = function(user, _callback){
        if( user.from == 'client' ) _callback(true);
        var sql =   " SELECT line_accounts.mid, line_accounts.pictureUrl, line_accounts.statusMessage, line_accounts.displayName "+
                	" FROM line_accounts"+
                	" WHERE line_accounts.mid = ?"+
                	" LIMIT 1";
      	connection = mysql.createConnection(mysqlConfig);
        connection.connect();   
        
        var query = connection.query({
            sql: sql,
                values: [user.profile.mid]
            }, function (error, results, fields) {

                if(error){
                    connection.end();
                    return _callback(false);
                } 
         
                if( results[0]){
                    connection.end();
                    return _callback(results[0]);
                }else{
                    connection.end();
                    return _callback(false);
                }
                    
            });
        
    }
