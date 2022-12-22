const { default: axios } = require("axios");

initSW();

function initSW(){
    if(!"serviceWorker" in navigator){
        // Service worker not supported
        console.warn('Service worker not supported');
        return;
    }

    // Register SW
    navigator.serviceWorker.register(swBase)
        .then((registration) => {
            registration.update();
            if(loggedIn){
                initPush();
            }
        })
        .catch((err) => {
            console.warn(err);
        });
}

function initPush(){
    if (!navigator.serviceWorker.ready) {
        console.warn(`Service worker isn't ready`);
        return;
    }

    new Promise(function (resolve, reject) {
        const permissionResult = Notification.requestPermission(function (result) {
            // Request Permission
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    }).then((permissionResult) => {
        if (permissionResult !== 'granted') {
            alert('We weren\'t granted permission.');
            throw new Error('We weren\'t granted permission.');
        }

        subscribeUser();
    });
}

function subscribeUser() {
    navigator.serviceWorker.ready
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(vapid_pubkey)
            };

            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then((pushSubscription) => {
            // console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
            storePushSubscription(pushSubscription);
        });
}

function urlBase64ToUint8Array(base64String) {
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function storePushSubscription(pushSubscription) {
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
    let formData = new FormData();
    formData.append('_token', token);

    let pushString = JSON.stringify(pushSubscription);
    let data = JSON.parse(pushString);
    for(const key in data){
        if(typeof data[key] === 'object'){
            let dynamicKey = key;
            let value = data[key];

            if(data[key] !== null){
                let child = data[key];
                for(const childKey in child){
                    dynamicKey = `${key}[${childKey}]`;
                    value = child[childKey];

                    formData.append(dynamicKey, value);
                }
            } else {
                formData.append(dynamicKey, value);
            }

        } else if(typeof data[key] === 'string'){
            formData.append(key, data[key]);
        }
    }

    axios.post(`${subscribeBase}`, formData)
        .then(function (response) {})
        .catch(function (error) {})
        .then(function (response) {});
}