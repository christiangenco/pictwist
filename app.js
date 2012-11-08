var express = require('express')
  , routes  = require('./routes')
  , user    = require('./routes/user')
  , http    = require('http')
  , path    = require('path')
  , mysql   = require('mysql');

// from https://github.com/felixge/node-mysql
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'pictwist',
  password : 'secret',
  database : 'pictwist'
});

// EXAMPLE MySQL QUERIES
connection.query('SELECT * FROM photos', function(err, rows){
  if(err) console.log(err);

  for (var i in rows) {
    console.log("Properities of the picture titled '" + rows[i]['title'] + "': ")
    console.log(rows[i]);
  }
});

console.log("Select a particular record");
var user_provided_album_title = "The Beach";
connection.query('SELECT * FROM albums WHERE title = ?', [user_provided_album_title], function(err, album){
  console.log("Selecting the album with title=" + user_provided_album_title + ": ")
  console.log(album);

  // insert a new record
  connection.query('INSERT INTO photos SET ?', {title: "new pic", path: "/tmp/new.png", album_id: album['id']}, function(err, result) {
    if (err) throw err;

    console.log("New photo id=" + result.insertId);
  });
});

var app = express();

app.configure(function(){
  app.set('port', process.env.PORT || 3000);
  app.set('views', __dirname + '/views');
  app.set('view engine', 'jade');
  app.use(express.favicon());
  app.use(express.logger('dev'));
  app.use(express.bodyParser());
  app.use(express.methodOverride());
  app.use(express.cookieParser('your secret here'));
  app.use(express.session());
  app.use(app.router);
  app.use(require('stylus').middleware(__dirname + '/public'));
  app.use(express.static(path.join(__dirname, 'public')));
});

app.configure(function(){
  app.use(express.errorHandler());
  app.locals.pretty = true;
});


app.configure('development', function(){
  app.use(express.errorHandler());
});

app.get('/', routes.index);
app.get('/users', user.list);

http.createServer(app).listen(app.get('port'), function(){
  console.log("Express server listening on port " + app.get('port'));
});
