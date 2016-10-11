'use strict';
var reg;
var sub;

var notify = {
    init: function (url_sw) {
        notify.on_start.init(url_sw);
    },
    on_start: {
        init: function (url_sw) {
            if ('serviceWorker' in navigator) {
                console.log('Service Worker is supported');
                navigator.serviceWorker.register('/notification_worker.js').then(function () {
                    return navigator.serviceWorker.ready;
                }).then(function (serviceWorkerRegistration) {
                    reg = serviceWorkerRegistration;
                    notify.data.subscribe();
                    console.log('Service Worker is ready :^)', reg);
                }).catch(function (error) {
                    console.log('Service Worker Error :^(', error);
                });
            }
        }
    },
    data: {
        subscribe: function () {
            var subscribe_id = '';
            navigator.serviceWorker.ready.then(function (serviceWorkerRegistration) {
                serviceWorkerRegistration.pushManager.getSubscription().then(function (subscription) {
                    if (!subscription) {
                        serviceWorkerRegistration.pushManager.subscribe({userVisibleOnly: true}).then(function (sub) {
                            subscribe_id = sub.endpoint.split("/").slice(-1)[0];
                        }).catch(function (e) {
                            console.log('Unable to register for push');
                        });
                    }
                    else {
                        console.log("DONE to register for push");
                    }
                })
            });

            /*
             var findvalue = 'gcm/send/'
             reg.pushManager.subscribe({userVisibleOnly: true}).then(function (pushSubscription) {
             sub = pushSubscription;
             console.log('Subscribed! Endpoint:', sub.endpoint);
             });
             if (sub !== null && sub.endpoint.length > 0) {
             // var idx = sub.endpoint.indexOf(findvalue);
             // return sub.endpoint.substring(idx + findvalue.length, sub.endpoint.length);
             return sub.endpoint.slice(sub.endpoint.lastIndexOf('/') + 1);
             }*/
            return subscribe_id;
        },
        unsubscribe: function () {
            sub.unsubscribe().then(function (event) {
                console.log('Unsubscribed!', event);
            }).catch(function (error) {
                console.log('Error unsubscribing', error);
            });
        }
    }
};