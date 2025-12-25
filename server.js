// const express = require("express");
// const fs = require("fs");
// const cors = require("cors");
import express from 'express';
import http from 'http';
import fs from 'fs';
import cors from 'cors';
import {Server} from 'socket.io';


const app = express();
app.use(cors());

const server = http.createServer(app);

const io = new Server(server, {
    cors: {
        origin: "https://matchbhai.com",
        methods: ["GET", "POST"]
    }
});

io.on("connection", (socket) => {
    console.log("Client connected");

    socket.emit('message', 'Welcome! This data is from the server.');

    
    // socket.on("get-file-data", () => {
    //     const filePath = "/var/www/laravel/storage/app/private/data.txt";

    //     fs.readFile(filePath, "utf8", (err, data) => {
    //         if (err) {
    //             socket.emit("file-error", err.message);
    //         } else {
    //             socket.emit("file-data", data);
    //         }
    //     });
    });

    socket.on("disconnect", () => {
        console.log("Client disconnected");
    });
});

server.listen(3001, "127.0.0.1", () => {
    console.log("Node Socket Server running on port 3001");
});