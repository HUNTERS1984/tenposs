var mysql = require("mysql");
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'phanvannhien',
  password : '',
  database : 'c9'
});



exports.checkExistAccounts = function(user, _callback){
        if( user.from == 'client' ) _callback(true);
        var sql =   " SELECT apps.bot_mid, apps.pictureUrl, apps.statusMessage, apps.displayName"+
                	" from line_accounts"+
                	" inner join app_users"+
                	" on app_users.id = line_accounts.app_user_id"+
                	" inner join apps"+
                	" on apps.id = app_users.app_id"+
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
