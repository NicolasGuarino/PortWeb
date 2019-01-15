<?php 
	
	include 'conexao.php';
	include 'push_notification.php';
	include 'enviar_push_web.php';
	

	if(isset($_GET['numero_etiqueta']) || isset($_REQUEST['documento_id'])){
		$conexao = conectar();
		$numero_etiqueta = $_GET['numero_etiqueta']; // NUMERO DO DOCUMENTO LIDA
		$responsavel_id = $_GET['responsavel_id']; // ID DO USUÁRIO LOGADO NO APP
		$dupla_autenticacao = $_GET['dupla_autenticacao']; // TRUE OU FALSE

		if(isset($_REQUEST['documento_id'])){
			$sql  = "select * from documento as d where documento_id = ".$_REQUEST['documento_id'];
			$numero_etiqueta =  exec_query($conexao, $sql)[0]['numero_etiqueta'];
		}
		
		$liberado = 0;
		$registro_acesso_id = 0;

		$tipo_autenticacao = ($dupla_autenticacao == "true")?  1 : 3;

		$sql  = "select * from documento as d ";
			
		if(eCarro($numero_etiqueta)) {
			$tipo_locomocao = "VEICULO";

			$sql .= "inner join veiculo as v on(d.documento_id = v.documento_id) ";
			$sql .= "inner join rel_usuario_veiculo as uv on(v.veiculo_id = uv.veiculo_id) ";
			$sql .= "inner join usuario as u on(u.usuario_id = uv.usuario_id)";
			
		}else{
			$tipo_locomocao = "PEDESTRE";

			$sql .= "inner join usuario as u on(d.documento_id = u.documento_id) ";
		}

		$sql .= "where d.numero_etiqueta = '".$numero_etiqueta."' limit 1;";
		$select = mysqli_query($conexao, $sql);
		
		if(mysqli_num_rows($select) != 0) {
			$array_dados_documento = mysqli_fetch_array($select);
			
			// VERIFICANDO A ULTIMA AÇÃO DO USUARIO (ENTRADA OU SAIDA)
			$query  = "select tipo_acao from usuario as u inner join rel_registro_usuario as ru on(ru.usuario_id=u.usuario_id) ";
			$query .= "inner join registro_acesso as ra on(ra.registro_acesso_id=ru.registro_acesso_id) ";
			$query .= "where u.usuario_id = ".$array_dados_documento['usuario_id']." order by ru.registro_acesso_id desc limit 1;";
			
			// Executando a query
			$exec = mysqli_query($conexao, $query);
			$ult_registro = mysqli_fetch_array($exec);

			// CONSULTANDO A EXCESSÃO PARA HOJE
			$query  = "select * from excessao ";
			$query .= "where usuario_id = ". $array_dados_documento['usuario_id'] ." and data = date_format(now(), '%Y-%m-%d');";

			// Executando a query
			$excessao = mysqli_query($conexao, $query);

			// CONSULTANDO A ESCALA PARA HOJE
			$query  = "select * from escala ";
			$query .= "where usuario_id = ". $array_dados_documento['usuario_id'] ." and dia_da_semana = weekday(now());";

			// Executando a query
			$escala = mysqli_query($conexao, $query);
			
			// Hora de entrada e saída
			$hora_entrada = null;
			$hora_saida   = null;

			// Definindo a hora de entrada e saída
			if(mysqli_num_rows($excessao) > 0){
				$excessao = mysqli_fetch_array($excessao);
				$hora_entrada = date_format(date_create($excessao['hora_entrada']), "H:i");
				$hora_saida   = date_format(date_create($excessao['hora_saida']),   "H:i");

			}else if(mysqli_num_rows($escala) > 0){
				$escala = mysqli_fetch_array($escala);
				$hora_entrada = date_format(date_create($escala['hora_entrada']), "H:i");
				$hora_saida   = date_format(date_create($escala['hora_saida']),   "H:i");
			}

			// Capturando a hora atual
			$hora_agora = date('H:i');

			// Verificando a entrada
			if($ult_registro['tipo_acao'] == 'SAIDA'){

				if($hora_agora == $hora_entrada){
					$liberado = 1;
					$title = "Acesso liberado";
					$description = "O acesso para a pessoa ".$array_dados_documento['nome']." foi liberado às " . $hora_agora;

				}else {
					$liberado = 0;
					$title = "Acesso negado";
					$description = "O acesso para a pessoa ".$array_dados_documento['nome']." foi negado às " . $hora_agora;
				}
			}

			// Verificando a saída
			if($ult_registro['tipo_acao'] == 'ENTRADA'){

				if($hora_agora == $hora_saida){
					$liberado = 1;
					$title = "Acesso liberado";
					$description = "O acesso para a pessoa ".$array_dados_documento['nome']." foi liberado às " . $hora_agora;

				}else {
					$liberado = 0;
					$title = "Acesso negado";
					$description = "O acesso para a pessoa ".$array_dados_documento['nome']." foi negado às " . $hora_agora;
				}
			}

			if($array_dados_documento) {
				date_default_timezone_set('America/Sao_Paulo');
				$dtObj = date_create(date('Y-m-d H:i:s'));
				// date_sub($dtObj, date_interval_create_from_date_string("15 seconds"));

				$agora = $dtObj->format('Y-m-d H:i:s');
				
				// VERIFICANDO A ULTIMA AÇÃO DO USUARIO (SE FOI ENTRADA OU SAIDA)
				$sql_tipo_acao  = "select * from usuario as u left join rel_registro_usuario as ru on(ru.usuario_id=u.usuario_id) ";
				$sql_tipo_acao .= "left join registro_acesso as ra on(ra.registro_acesso_id=ru.registro_acesso_id) ";
				$sql_tipo_acao .= "where u.usuario_id = ".$array_dados_documento['usuario_id']." order by ru.registro_acesso_id desc limit 1;";
				
				$select_tipo_acao = mysqli_query($conexao, $sql_tipo_acao);
				$rs = mysqli_fetch_array($select_tipo_acao);

				$tipo_acao = ($rs['tipo_acao'] == "ENTRADA") ? "SAIDA" : "ENTRADA";
					
				$veiculo_id = (eCarro($numero_etiqueta)) ? $array_dados_documento['veiculo_id'] : "null";

				// ID da empresa de destino
				$empresa_destino_id = 'null';

				// Inserindo o ID da empresa de destino se o usuário for visitante
				if($rs['tipo_usuario_id'] == 4){

					if($tipo_acao == 'ENTRADA'){

						if($_GET['empresa_destino_id'] != 0){
							$empresa_destino_id = $_GET['empresa_destino_id'];
						}

					}else if($tipo_acao == 'SAIDA') {
						$empresa_destino_id = ($rs['empresa_destino_id'] == '')? 'null' : $rs['empresa_destino_id'];
					}
				}

				// INSERINDO REGISTRO DE ACESSO
				$sql  = "insert into registro_acesso (veiculo_id, responsavel_id, tipo_acao, acionamento_id, tipo_locomocao, hora, liberacao, tipo_autenticacao, empresa_destino_id) ";
				$sql .= "values (".$veiculo_id.", ".$responsavel_id.", '".$tipo_acao."', 3, '".$tipo_locomocao."', '".$agora."', " . $liberado . ", ".$tipo_autenticacao.", ". $empresa_destino_id .");";

				mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

				// COLETANDO O ID CADASTRADO
				$registro_acesso_id = mysqli_insert_id($conexao);
				
				// INSERINDO O REGISTRO NA TABELA DE RELACIONAMENTO REGISTRO-USUARIO
				$sql = "insert into rel_registro_usuario (registro_acesso_id, usuario_id, documento_id) ";
				$sql .= "values(".$registro_acesso_id.", ".$array_dados_documento['usuario_id'].", ".$array_dados_documento['documento_id'].");";
				mysqli_query($conexao, $sql);

				// ATUALIZANDO O CAMPO ULTIMA_ATUALIZACAO DO USUARIO
				$sql  = "update usuario set ultima_atualizacao = '".$agora."' where usuario_id = " .$array_dados_documento['usuario_id']. ";";
				mysqli_query($conexao, $sql);

				// ATUALIZANDO O CAMPO 'ULTIMA_ATUALIZACAO' DO RELACIONAMENTO ENTRE USUÁRIO E STATUS
				$sql  = "update rel_status_usuario set hora = '". $agora ."' where usuario_id = ". $rs['usuario_id'] ." and hora = '". $rs['ultima_atualizacao'] ."';";
				mysqli_query($conexao, $sql);

				// COLETANDO DADOS DA EMPRESA
				if(isset($_GET['empresa_destino_id'])){

					$sql  = "select e.empresa_id, e.nome from empresa as e ";
					$sql .= "where e.empresa_id = ".$empresa_destino_id.";";

				}else {
					$sql  = "select e.empresa_id, e.nome from empresa as e ";
					$sql .= "inner join rel_empresa_funcionario as reu on reu.empresa_id = e.empresa_id ";
					$sql .= "inner join usuario as u on u.usuario_id = reu.usuario_id ";
					$sql .= "where u.usuario_id = ".$array_dados_documento['usuario_id'].";";
				}

				$select = mysqli_query($conexao, $sql);
				$array_dados_empresa = mysqli_fetch_array($select);

				// INSERINDO REGISTRO NA TABELA DE RELACIONAMENTO REGISTRO-EMPRESA
				$sql  = "insert into rel_registro_empresa (empresa_id, registro_acesso_id) ";
				$sql .= "values (".$array_dados_empresa['empresa_id'].", ".$registro_acesso_id.");";
				mysqli_query($conexao, $sql);

				// ENVIO DE NOTIFICAÇÃO PARA O RESPONSÁVEL DA EMPRESA
				// Lista de token dos usuários responsáveis
				$lista_token = [];


				// Consultando o token dos usuários responsáveis da empresa
				$query  = "select u.usuario_id, u.nome, u.token_firebase, u.token_web, tp.nome as 'tipo', e.empresa_id from usuario as u ";
				$query .= "inner join rel_empresa_funcionario as ef on(ef.usuario_id = u.usuario_id) ";
				$query .= "inner join empresa as e on(e.empresa_id = ef.empresa_id) ";
				$query .= "inner join tipo_usuario as tp on(tp.tipo_usuario_id = u.tipo_usuario_id) ";
				$query .= "where tp.tipo_usuario_id = 3 and e.empresa_id = ". $array_dados_empresa['empresa_id'] .";";

				// Executando a query
				$exec = mysqli_query($conexao, $query);
				
				// Preenchendo a lista de token
				while($usuario_responsavel = mysqli_fetch_array($exec)) {
					$lista_token[] = $usuario_responsavel['token_firebase'];
					$lista_token_web[] = $usuario_responsavel['token_web'];
				}

				// Verificando se existe algum token
				if(count($lista_token) > 0){


					// Consultando o registro de acesso realizado
					$query  = "select * from registro_acesso ";
					$query .= "where registro_acesso_id = ". $registro_acesso_id .";";
					
					// Executando a query
					$exec 	  		 = mysqli_query($conexao, $query);
					$registro_acesso = mysqli_fetch_array($exec);

					// Obtendo a data e hora
					$hora = date_format(date_create($registro_acesso['hora']), "H:i");
					$data = date_format(date_create($registro_acesso['hora']), "d/m/Y");

					// ENVIO DE NOTIFICAÇÃO
					$click_action = "INICIAR_PORTARIA";

					// Dados da notificação
					$object_in_array = [
						"usuario" 		 => $array_dados_documento['nome'],
						"foto_usuario" 	 => $array_dados_documento['foto'],
						"empresa" 		 => $array_dados_empresa['nome'],
						"tipo_locomocao" => $registro_acesso['tipo_locomocao'],
						"tipo_acao" 	 => $registro_acesso['tipo_acao'],
						"hora" 			 => $hora,
						"data" 			 => $data,
						"liberacao"		 => $liberado
					];

					$notification = array(
						'title' => $title,
						'body' => $description,
						'icon' => 'empresarial_logo.png',
						'click_action' => 'http://www.nuflame.com.br/portaria/lista_acesso.php'
					);

					// Enviando notificação
					$retorno = push_notification($title, $description, $click_action, $object_in_array, $lista_token);
					$retorno = enviar_push_web($notification, $lista_token_web);
				}
			}
		}

		$liberacao_acesso = array("liberacao_acesso" => $liberado, "registro_acesso_id" => $registro_acesso_id);

		echo json_encode($liberacao_acesso);
		mysqli_close($conexao);
	}


	function eCarro($num_etiqueta){
		switch (strtoupper($num_etiqueta[0])) {
			case 'A': // AUTOMOVEL
				return 1;
				break;
			
			case 'C': // CONDOMINO
				return 0;
				break;

			default:
				return 0;
		}
	}

?>