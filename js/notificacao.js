

	// Configurações iniciais do firebase
    var config = {
        apiKey: "AIzaSyAO8XfOOkFlMeZeS9_E1y2fo3srmXappIw",
        authDomain: "portaria-49674.firebaseapp.com",
        databaseURL: "https://portaria-49674.firebaseio.com",
        projectId: "portaria-49674",
        storageBucket: "portaria-49674.appspot.com",
        messagingSenderId: "46880934400"
    };

	firebase.initializeApp(config); // Inicalizando o app firebase

	var messaging = firebase.messaging();

	// Pedindo permissão de notificação
	messaging.requestPermission()
	.then(function() {
		console.log('Permissao garantida');
		return messaging.getToken();
	})
	.then(function(token) {
		// Coletando token
		$.getJSON("json/inserir_token_web.php", {token:token}, function(retorno) {
			console.log('Token inserido', token);
		})
	})
	.catch(function() {
		console.log('Error ocurred');
	});

	// Tratando mensagem recebida
	messaging.onMessage(function(payload) {
		console.log('OnMessagem', payload);

		toastr.options = {positionClass:'toast-bottom-right', escapeHTML:true}
		toastr.info(payload.notification.body, payload.notification.title);
	});
