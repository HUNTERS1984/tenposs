var mysql = require("mysql");
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'phanvannhien',
  password : '',
  database : 'c9'
});



var Messages = {
    getMessageHistory : function(from,to,limit,callback){
        
        connection.connect(function(err){
            if(err) return;
            var sql =   " SELECT m.room_id,m.to_mid, m.from_mid, m.message"+
                    	" FROM messages m"+
                    	" WHERE"+ 
                    	" 	(m.from_mid = ? AND m.to_mid = ?)"+
                    	"	OR (m.to_mid = ?  AND m.from_mid = ?)"+
                    	" ORDER BY created_at DESC"+
                    	" LIMIT ?";
            connection.query({
                sql: 'SELECT * FROM `books` WHERE `author` = ?',
                    values: [from,to,from,to,limit]
                }, function (error, results, fields) {
                    callback(results);
                });
        });
    }
}

exports = exports.module = Messages; 