var mysql = require("mysql");
var config= require("./../config");
console.log( 'Config in lineacount' );
console.log(config);

var connection = mysql.createConnection({
  host     : config.database.host,
  user     : config.database.user,
  password : config.database.password,
  database : config.database.database
});



exports.checkExistAccounts = function(user, _callback){
        if( user.from == 'client' ) _callback(true);
        var sql =   " line_accounts.mid, line_accounts.pictureUrl, line_accounts.statusMessage, line_accounts.displayName "+
                	" from line_accounts"+
                	" WHERE line_accounts.mid = ?"+
                	" LIMIT 1";
      	
        connection.query({
            sql: sql,
                values: [user.profile.mid]
            }, function (error, results, fields) {
                if(error) return _callback(false);
                console.log(results[0]);
                if( results[0])
                    return _callback(results[0]);
                else
                    return _callback(false);
            });
        
    }
