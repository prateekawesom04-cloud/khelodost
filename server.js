const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const path = require('path');

const app = express();
const server = http.createServer(app);
const io = new Server(server);
const fs = require('fs');
const path = require('path');

// Serve static files
app.use(express.static(path.join(__dirname, 'storage/app/private')));

fs.readFile('./example.txt', 'utf8', (err, data) => {
    if (err) {
        console.error('Error reading file:', err);
        return;
    }
    // Socket.IO connection handler
    io.on('connection', (socket) => {
    console.log('A user connected');

        // Handle new messages
        socket.on('sendData', (msg) => {
            console.log('Message received:', msg);
            // Broadcast the message to all connected clients
            io.emit('sendData', msg);
            });

        // Handle disconnection
        socket.on('disconnect', () => {
            console.log('A user disconnected');
        });
    });
});


const PORT = process.env.PORT || 3000;
server.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});