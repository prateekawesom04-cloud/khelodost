// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     wsHost: import.meta.env.VITE_PUSHER_HOST,
//     wsPort: import.meta.env.VITE_PUSHER_PORT,
//     wssPort: import.meta.env.VITE_PUSHER_PORT,
//     enabledTransports: ["ws", "wss"],
// });

import Echo from 'laravel-echo';
    window.io = require('socket.io-client');

    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':3000', // Or your Socket.IO server URL
    });