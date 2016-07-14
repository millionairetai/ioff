var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res){
  res.sendfile('index.html');
});

io.on('connection', function(socket){
  //notify to user to get notification
  socket.on('notify', function(msg){
    console.log('receive');
    io.sockets.emit('broadcast','yes');
  });
});

http.listen(3000, function(){
  console.log('listening on *:3000');
});