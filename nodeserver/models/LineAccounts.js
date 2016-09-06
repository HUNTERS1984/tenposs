var mysql = require("mysql");
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'phanvannhien',
  password : '',
  database : 'c9'
});



exports.checkExistAccounts = function(user, _callback){
        if( user.from == 'client' ) _callback(true);
        var sql =   " SELECT count(*) as total"+
                	" FROM line_accounts"+
                	" WHERE mid = ?"+
                	" LIMIT 1";
                	
        connection.query({
            sql: sql,
                values: [user.profile.mid]
            }, function (error, results, fields) {
                if(error) return _callback(false);
                console.log(results[0]);
                if( results[0].total > 0 )
                    return _callback(true);
                else
                    return _callback(false);
            });
        
    }
