var mysql = require("mysql");
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'phanvannhien',
  password : '',
  database : 'c9'
});




exports.getMessageHistory = function(from, to, limit, _callback){
    
        var sql =   " SELECT m.room_id,m.to_mid, m.from_mid, m.message"+
                	" FROM messages m"+
                	" WHERE"+ 
                	" 	(m.from_mid = ? AND m.to_mid = ?)"+
                	"	OR (m.to_mid = ?  AND m.from_mid = ?)"+
                	" ORDER BY created_at DESC"+
                	" LIMIT ?";
                	
        connection.query({
            sql: sql,
                values: [from,to,from,to,limit]
            }, function (error, results, fields) {
                if(error) return false;
                return _callback(results);
            });
        
    }



exports.getMessageClientHistory = function(room_id, from,to, limit, _callback){
        
    	var sql =  " SELECT m.room_id,m.to_mid, m.from_mid, m.message, m.created_at, l.displayName, l.pictureUrl, l.statusMessage"+
    	" FROM messages m, line_accounts l"+
    	" WHERE"+ 
    		" (m.from_mid = ? AND m.to_mid = ? )"+
    		" OR (m.to_mid = ? AND m.from_mid = ?)"+
    		" AND (m.room_id = ?)"+
    		" AND IF ( m.from_mid != ?, ?, ? ) = l.mid"+
    	" ORDER BY created_at DESC"+
    	" LIMIT ?";

   	
        connection.query({
            sql: sql,
                values: [from,to,from,to,room_id, to,from,to,limit]
            }, function (error, results, fields) {
                if(error) return false;
                return _callback(results);
            });
        
    }
