import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }
});

// dynamically subscribe to private channel if user is logged in
if (window.Laravel.userId) {
    window.Echo.private(`users.${window.Laravel.userId}`)
        .listen('NewNotification', (e) => {
            console.log('Notification:', e.data);

            // // optional: show in notification bell dropdown
            // const notifList = document.getElementById('notifications-list');
            // if(notifList){
            //     const li = document.createElement('li');
            //     li.innerHTML = `<a href="${e.data.url}">${e.data.message}</a>`;
            //     notifList.prepend(li);
            // }
        });
}
