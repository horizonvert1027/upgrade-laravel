importScripts('https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.9.1/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyBOuFvJ3hBrwMZ8taDtakASd5-Ol_4DzjM",
    authDomain: "oyebesmartestnoti.firebaseapp.com",
    projectId: "oyebesmartestnoti",
    storageBucket: "oyebesmartestnoti.appspot.com",
    messagingSenderId: "580791977582",
    appId: "1:580791977582:web:6e258f70248ef391e6887f",
    measurementId: "G-C673Z2DBD3"
});

const messaging = firebase.messaging();
