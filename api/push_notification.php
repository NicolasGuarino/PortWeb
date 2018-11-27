<?php
	/*
		Criado por Samuel Rocha no dia 01/07/2017 às 08:54
		Modificado pela última vez em: 01:07:2017 às 09:10 por Samuel Rocha

		**** Descrição ****
		push_notification : Função que acessa o webservice do firebase e envia notificações os dispositivos especificados.
		retornos: 1-> Notificação enviada com sucesso; 2-> Notificação Falhou
		
		**** Parâmetros ****
		title -> Título da notificação
		description -> Subtítulo escrito em cinza na notificação
		click_action -> "name" da TAG "action" da tela descrita dentro do intent-filter no manifest
		object_in_array -> passar objeto na estrutura chave valor. Ex: object_in_array = array("key_teste" => "valor") 
		registration_ids -> passar os ids firebase dos dispositivos que serão enviados a notificação em array simples. Ex: registration_ids = ['hash1', 'hash2'] 
		
		**** Exemplo teste ****
		$title = "Título da notificação";
		$description = "Descrição da notificação";
		$click_action = "br.com.pacote_NOMEDESEJADO";
		$object_in_array = array("informacao_teste" => "Informação que to enviando");
		$registration_ids = ['dYn1n2668c0:APA91bHsdJWQ5zIbtdVhqYXam0_2-vpNY_Eec2AgR6f2v4nhxfv3ljqDlDkBVkQ3O2GmvaBeF0PMWAqOhbMr-A5R05kAHTn61-SGVE3Ui0IDbkciBkirvlk5fN6Fg57CDaZBiAt7vmJb'];
		$retorno = push_notification($title, $description, $click_action, $object_in_array, $registration_ids);	
		echo $retorno;
	*/

	/*	$title = "Registro de Acesso";
		$description = "Acesso detectado";
		$click_action = "Notificacao";
		$registro_id = $_REQUEST['registro_id'];
		$object_in_array = array("registro_acesso" => $registro_id);
		$registration_ids = ['dYn1n2668c0:APA91bHsdJWQ5zIbtdVhqYXam0_2-vpNY_Eec2AgR6f2v4nhxfv3ljqDlDkBVkQ3O2GmvaBeF0PMWAqOhbMr-A5R05kAHTn61-SGVE3Ui0IDbkciBkirvlk5fN6Fg57CDaZBiAt7vmJb'];
		$retorno = push_notification($title, $description, $click_action, $object_in_array, $registration_ids);	
		echo $retorno; */

	function push_notification( $title, $description, $click_action, $object_in_array, $registration_ids){

		//Definindo a chave de acesso do servidor do firebase.
		//Essa chave é obtida ao criar um projeto no firebase e acessando às configurações > chave do servidor
		define( 'API_ACCESS_KEY', 'AAAACupSSgA:APA91bG89KQ8U_8z4GmxfnVpEIhEBA9hdbKHBKsyFtvmufPQIBnTSAmTQoMarIUP7h0jT0Yb5Qm_eok6B6JggCcEt6okoUInbCJLMavq-80mTI64jd9e9VFOlClS_mnLwQCIox_DOl9t');

		//Montando a notificação
		$notifications = [
		    'title'         => $title,
			'body'          => $description,
			'click_action'  => $click_action,
			'sound' => "default",
			'color' => '#FFFFFF'
		];

		//Recebendo o objeto com as informações que será mostrada na tela do aplicativo
		$data = $object_in_array;

		//Montando o objeto propriamente dito da notificação para o firebase
		$fields = [
		    'registration_ids'  => $registration_ids,
		    'notification'              => $notifications,
		    'data' => $data
		];	

		//Montando cabeçalhos
		$headers = [
		    'Authorization: key=' . API_ACCESS_KEY,
		    'Content-Type: application/json'
		];

		//Convertendo o objeto da notificação do firebase em json
		$fields = json_encode( $fields );

		//Realizando o envio para o firebase
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, $fields );
		$result = curl_exec($ch );
		curl_close( $ch );

		// !!! Não Apagar - Linha utilizada a fim de testes. !!!
		// Deve-se descomentá-la e comentar à partir do "$result = explode..." até o fim do else do último "return0;"
		// return $result;

		//Tratando resultado de sucesso e falha do envio.
		// $result = explode(",", $result);

		// if (strpos($result[1], 'success') !== false) {
		//     $result = substr($result[1],strrpos($result[1],":")+1, strlen($result[1])-strrpos($result[1],":")+1); 
		//     if($result > 0){
		//     	return 1;
		//     }else{
		//     	return 0;
		//     }
		// }else{
		// 	return 0;
		// }
	}
	