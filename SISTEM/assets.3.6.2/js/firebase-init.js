// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyCidEbgcZRhHCyZOUbeMxQ_eqoaz500Gs0",
    authDomain: "notificaciones-asms.firebaseapp.com",
    databaseURL: "https://notificaciones-asms.firebaseio.com",
    projectId: "notificaciones-asms",
    storageBucket: "notificaciones-asms.appspot.com",
    messagingSenderId: "597606122364",
    appId: "1:597606122364:web:c2f8eaab3837f59870daf9"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);



// Retrieve Firebase Messaging object.
		const messaging = firebase.messaging();
		
		// Add the public key generated from the console here.
		messaging.usePublicVapidKey("BK8IkflXLEWRkuQLaSHwtVVKEQfg5YY2IEvZEEbzyBQbbgURV7JEp-eNxSIBV0ts7sMLlKVPqoTXMI2GXl8n6_Y");
		
		// IDs of divs that display Instance ID token UI or request permission UI.
		const tokenDivId = 'token_div';
		const permissionDivId = 'permission_div';
		
		Notification.requestPermission().then((permission) => {
			if (permission === 'granted') {
			  console.log('Notification permission granted.');
			  // TODO(developer): Retrieve an Instance ID token for use with FCM.
			  // ...
			} else {
			  console.log('Unable to get permission to notify.');
			}
		});
		
		messaging.onTokenRefresh(() => {
			messaging.getToken().then((refreshedToken) => {
				console.log('Token refreshed.');
				// Indicate that the new Instance ID token has not yet been sent to the
				// app server.
				setTokenSentToServer(false);
				// Send Instance ID token to app server.
				sendTokenToServer(refreshedToken);
				// [START_EXCLUDE]
				// Display new Instance ID token and clear UI of all previous messages.
				resetUI();
				// [END_EXCLUDE]
			}).catch((err) => {
				console.log('An error occurred while retrieving token. ', err);
				showToken('Error retrieving Instance ID token. ', err);
				setTokenSentToServer(false);
			});
		});
		
		// Handle incoming messages. Called when:
		// - a message is received while the app has focus
		// - the user clicks on an app notification created by a service worker
		//   `messaging.setBackgroundMessageHandler` handler.
		messaging.onMessage((payload) => {
			console.log('Message received. ', payload);
			// [START_EXCLUDE]
			// Update the UI to include the received message.
			appendMessage(payload);
			// [END_EXCLUDE]
		});
	
		
		////////////////////////////////////////// MANAGEMENT ////////////////////////////////
		function sendTokenToServer(currentToken) {
			if (!isTokenSentToServer()) {
				console.log('Sending token to server...');
				// TODO(developer): Send the current token to your server.
				setTokenSentToServer(true);
			} else {
				console.log('Token already sent to server so won\'t send it again ' +'unless it changes');
			}
		}
		
		function isTokenSentToServer() {
			return window.localStorage.getItem('sentToServer') === '1';
		}
		function setTokenSentToServer(sent) {
			window.localStorage.setItem('sentToServer', sent ? '1' : '0');
		}
		function resetUI() {
			//clearMessages();
			showToken('loading...');
			// [START get_token]
			// Get Instance ID token. Initially this makes a network call, once retrieved
			// subsequent calls to getToken will return from cache.
			messaging.getToken().then((currentToken) => {
				if (currentToken) {
					sendTokenToServer(currentToken);
					//updateUIForPushEnabled(currentToken);
				} else {
					// Show permission request.
					console.log('No Instance ID token available. Request permission to generate one.');
					// Show permission UI.
					//updateUIForPushPermissionRequired();
					setTokenSentToServer(false);
				}
			}).catch((err) => {
				console.log('An error occurred while retrieving token. ', err);
				showToken('Error retrieving Instance ID token. ', err);
				setTokenSentToServer(false);
			});
			// [END get_token]
		}