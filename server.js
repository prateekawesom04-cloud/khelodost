const express = require("express");
const fs = require("fs");
const https = require('https');
const cors = require("cors");
// const io = require('socket.io')(http);
const socketIo = require('socket.io');

// import express from 'express';
// import http from 'http';
// import fs from 'fs';
// import cors from 'cors';
// import {Server} from 'socket.io';


const app = express();

const options = {
  key: fs.readFileSync("/etc/letsencrypt/live/matchbhai.com/privkey.pem"),
  cert: fs.readFileSync("/etc/letsencrypt/live/matchbhai.com/fullchain.pem"),
};
// app.use(cors());

// app.use(cors({
//   origin: "*",
//   credentials: true
// }));

// app.set( "ipaddr", "72.60.97.123" );
// const server = http.createServer(app);
const server = https.createServer(options, app);

// const io = socketIo(server);
// const server = http.createServer();
// const io = new Server(server);

server.listen(3001, () => {
    console.log("Node Socket Server running on port 3001");
});

const io = socketIo(server, {
    cors: {
        origin: "https://matchbhai.com",
        methods: ["GET", "POST"]
    }
});

io.on("connection", (socket) => {
    console.log("Client connected");

    socket.emit('message', 'Welcome! This data is from the server.');
    
    socket.on("disconnect", () => {
        console.log("Client disconnected");
    });
});

    
