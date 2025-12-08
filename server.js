// server.js
const server = require('http').createServer();
const io = require('socket.io')(server);
const port = 3000; // Choose a suitable port

io.on('connection', (socket) => {
    console.log('Client connected:', socket.id);

    socket.on('eventData', (data) => {
        console.log('Received data from PHP:', data);
        // Broadcast the data to all connected clients
        io.emit('eventDataListener', data.eventData); 
    });

    socket.on('disconnect', () => {
        console.log('Client disconnected:', socket.id);
    });
});

server.listen(port, () => {
    console.log(`Socket.IO server listening on port ${port}`);
});