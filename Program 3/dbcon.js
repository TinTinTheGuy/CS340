var mysql = require('mysql');
var pool = mysql.createPool({
  connectionLimit : 10,
  host            : 'classmysql.engr.oregonstate.edu',
  user            : 'cs340_tont',
  password        : 'Hanakasa01',
  database        : 'cs340_tont'
});
module.exports.pool = pool;
