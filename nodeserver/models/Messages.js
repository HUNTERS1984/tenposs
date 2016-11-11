var mysql = require("mysql");
var config= require("./../config");

var mysqlConfig = {
  host     : config.database.host,
  user     : config.database.user,
  password : config.database.password,
  database : config.database.database
};
var connection;

exports.getMessageHistory = function(from, to, limit, _callback){
    
        var sql =   " SELECT m.room_id,m.to_mid, m.from_mid, m.message, m.created_at"+
                	" FROM messages m"+
                	" WHERE"+ 
                	" 	(m.from_mid = ? AND m.to_mid = ?)"+
                	"	OR (m.to_mid = ?  AND m.from_mid = ?)"+
                	" ORDER BY created_at"+
                	" LIMIT ?";
        connection = mysql.createConnection(mysqlConfig);
        connection.connect();       	
        connection.query({
            sql: sql,
                values: [from,to,from,to,limit]
            }, function (error, results, fields) {
                if(error){
                    connection.end();
                    return false;
                }else{
                    connection.end();
                    return _callback(results);
                }
            });
        
    }



exports.getMessageClientHistory = function(room_id, from,to, limit, _callback){
        
    var sql = " SELECT l.mid, l.displayName, l.pictureUrl, l.statusMessage, h.room_id,h.to_mid, h.from_mid, h.message, h.created_at"+
	" FROM line_accounts l"+
	" INNER JOIN"+
		" (SELECT m.room_id,m.to_mid, m.from_mid, m.message, m.created_at"+
		" FROM messages m"+
		" WHERE (m.from_mid = ?"+
		"	AND m.to_mid = ? )"+
		" OR (m.to_mid = ?"+
		"	AND m.from_mid = ?)"+
		" AND (m.room_id = ? )) as h"+
	" ON h.from_mid = l.mid OR h.to_mid = l.mid"+
	" LIMIT ?";

        connection = mysql.createConnection(mysqlConfig);
        connection.connect(); 
   	
        var query = connection.query({
            sql: sql,
                values: [from,to,from,to,room_id,limit]
            }, function (error, results, fields) {
                if(error) {
                    connection.end();
                    return false;
                }else{
                    connection.end();
                    console.log(query.sql);
                    return _callback(results);
                }
                
            });
        
    }


exports.saveMessage = function(room_id, from,to, message, _callback){
        
    	var data = {
    	    room_id : room_id,
    	    from_mid: from,
    	    to_mid: to,
    	    message: message,
    	    created_at: new Date().getTime()
    	};
        connection = mysql.createConnection(mysqlConfig);
        connection.connect(); 
        
   	    var query = connection.query('INSERT INTO messages SET ?', data, function(err, result) {
            if (err){
                connection.end();
                return false;
            }else{
                console.log(query.sql);
                connection.end();
                return result.insertId;
            }
           
        });

    }
