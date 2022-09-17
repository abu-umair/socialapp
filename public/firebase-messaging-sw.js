importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/3.9.0/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
  apiKey: "AIzaSyBcTC8tM4gzchNVly5107U0v1Bj6D_JdAQ",
  authDomain: "push-notification-040809.firebaseapp.com",
  projectId: "push-notification-040809",
  storageBucket: "push-notification-040809.appspot.com",
  messagingSenderId: "284335827192",
  appId: "1:284335827192:web:fea1ded64917cbf99c330d",
  measurementId: "G-EYMQ6FPX5B"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: 'https://images.theconversation.com/files/93616/original/image-20150902-6700-t2axrz.jpg' //your logo here
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});