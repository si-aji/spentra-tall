const cacheName = 'spentra-pwa-v1';
const appShellFiles = [];
const contentToCache = appShellFiles;

// Install Service Worker
self.addEventListener('install', (e) => {
    // console.log("===== Installed =====");
});

// Fetch Asset
self.addEventListener('fetch', (e) => {
    // console.log("===== Fetch =====");
});

// Push Notification
self.addEventListener('push', (e) => {
    // console.log('===== SW Push Add Event Listener =====');
    // console.log(e);
    // console.log(e.data);
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (e.data) {
        var msg = e.data.json();
        console.log(msg);
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            actions: msg.actions,
            data: msg.data ?? null
        }));
    }
}); 
self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    console.log(event.notification);
    // console.log(event);
    // clients.openWindow(`${baseUrl}/${event.action}`);

    event.waitUntil((async () => {
        let actionTarget = event.action;

        if(actionTarget !== ''){
            let actionUrl = new URL(actionTarget);
            console.log(actionUrl);
            const allClients = await clients.matchAll({
                includeUncontrolled: true
            });

            // Let's see if we already have a chat window open:
            for (const client of allClients) {
                const url = new URL(client.url);
                console.log(url);
        
                if(url.pathname === actionUrl.pathname){
                    return client.focus();
                }
            }

            clients.openWindow(actionUrl.pathname);
        } else if(event.notification.data){
            if(event.notification.data.url){
                actionUrl = new URL(event.notification.data.url);
                const allClients = await clients.matchAll({
                    includeUncontrolled: true
                });
    
                // Let's see if we already have a chat window open:
                for (const client of allClients) {
                    const url = new URL(client.url);
                    if(url.pathname === actionUrl.pathname){
                        return client.focus();
                    }
                }
    
                clients.openWindow(actionUrl.pathname);
            }
        }
    })());
}, false);