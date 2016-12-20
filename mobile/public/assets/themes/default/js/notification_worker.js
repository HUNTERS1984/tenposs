/*
 *
 *  Push Notifications codelab
 *  Copyright 2015 Google Inc. All rights reserved.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      https://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License
 *
 */

// Version 0.1

'use strict';

// TODO
console.log('Started', self);
// var key_sub = notify.data.subscribe();

self.addEventListener('install', function (event) {
    self.skipWaiting();
    console.log('Installed', event);
});

self.addEventListener('activate', function (event) {
    console.log('Activated', event);
});

function getEndpoint() {
    return self.registration.pushManager.getSubscription()
        .then(function (subscription) {
            if (subscription) {
                return subscription.endpoint;
            }
            throw new Error('User not subscribed');
        });
}

self.addEventListener('push', function (event) {
    event.waitUntil(
        getEndpoint().then(function (endpoint) {
            return fetch('./get_notification/' + endpoint.slice(endpoint.lastIndexOf('/') + 1));
        }).then(function (response) {
            return response.json().then(function (data) {
                console.log(data);
                var title = data.title;
                var body = data.description;
                var icon = data.icon;
                var tag = 'temp-tag';
                var url = data.url;

                return self.registration.showNotification(title, {
                    body: body,
                    icon: icon,
                    tag: url,
                    url: url,
                })
            });
        })
    );
})
;

self.addEventListener('notificationclick', function (event) {
    console.log('Notification click: tag', event.notification.tag);
    // Android doesn't close the notification when you click it
    // See http://crbug.com/463146
    var url = event.notification.tag;
    event.notification.close();

    // Check if there's already a tab open with this URL.
    // If yes: focus on the tab.
    // If no: open a tab with the URL.
    event.waitUntil(
        clients.matchAll({
            type: 'window'
        })
            .then(function (windowClients) {
                console.log('WindowClients', windowClients);
                for (var i = 0; i < windowClients.length; i++) {
                    var client = windowClients[i];
                    console.log('WindowClient', client);
                    if (client.url === url && 'focus' in client) {
                        return client.focus();
                    }
                }
                if (clients.openWindow) {
                    return clients.openWindow(url);
                }
            })
    );
});