import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';


window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    authEndpoint: "/broadcasting/auth", // penting untuk private channel
});

window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log('✅ Pusher Connected!');
});
window.Echo.connector.pusher.connection.bind('error', (err) => {
    console.error('Pusher Error:', err);
});