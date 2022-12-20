const mysql = require('mysql');
const config = require('config');

module.exports = mysql.createConnection({
  host: config.get('hostDB'),
  database: config.get('nameDB'),
  user: config.get('userDB'),
  password: config.get('passwordDB'),
});
