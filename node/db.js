const mysql = require('mysql');

let con;

function handleDisconnect() {
  con = mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE
  });

  con.connect(function (err) {
    if (err) {
      console.error('error when connecting to db:', err);
      setTimeout(handleDisconnect, 2000);
    }
  });

  con.on('error', function (err) {
    console.error('db error', err);

    handleDisconnect();
  });
}

handleDisconnect();

module.exports = con;
