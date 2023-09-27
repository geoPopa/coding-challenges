const express = require('express');
const app = express();
const server = require('http').createServer(app);
const path = require('path');
const io = require('socket.io')(server);
const port = 3001;

app.use(express.static(path.join(__dirname, 'public')));

server.listen(port, () => {
  console.log(`Server listening on *:${port}`);
});
