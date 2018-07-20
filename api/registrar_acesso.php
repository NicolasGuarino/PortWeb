<?php 
	
	include 'conexao.php';
	include 'push_notification.php';

	if(isset($_GET['numero_etiqueta'])){
		$conexao = conectar();

		$numero_etiqueta = $_GET['numero_etiqueta']; // NUMERO DA ETIQUETA LIDA
		$responsavel_id = $_GET['responsavel_id']; // ID DO USUÁRIO LOGADO NO APP
		$dupla_autenticacao = $_GET['dupla_autenticacao']; // TRUE OU FALSE

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
			$liberado = 1;
			$title = "Acesso liberado";
			$description = "O acesso para a pessoa ".$array_dados_documento['nome']." foi liberado às ".date('H:m:s');

			$array_dados_documento = mysqli_fetch_array($select);

			if($array_dados_documento) {
				date_default_timezone_set('America/Sao_Paulo');
				$dtObj = date_create(date('Y-m-d H:i:s'));
				date_sub($dtObj, date_interval_create_from_date_string("15 seconds"));

				$agora = $dtObj->format('Y-m-d H:i:s')."<br/>";
				
				// VERIFICANDO A ULTIMA AÇÃO DO USUARIO (SE FOI ENTRADA OU SAIDA)
				$sql_tipo_acao  = "select * from usuario as u inner join rel_registro_usuario as ru on(ru.usuario_id=u.usuario_id) ";
				$sql_tipo_acao .= "inner join registro_acesso as ra on(ra.registro_acesso_id=ru.registro_acesso_id) ";
				$sql_tipo_acao .= "where u.usuario_id = ".$array_dados_documento['usuario_id']." order by ru.registro_acesso_id desc limit 1;";

				$select_tipo_acao = mysqli_query($conexao, $sql_tipo_acao);
				$rs = mysqli_fetch_array($select_tipo_acao);

				$tipo_acao = ($rs['tipo_acao'] == "ENTRADA") ? "SAIDA" : "ENTRADA";

				$veiculo_id = (eCarro($numero_etiqueta)) ? $array_dados_documento['veiculo_id'] : "null";

				// INSERINDO REGISTRO DE ACESSO
				$sql  = "insert into registro_acesso (veiculo_id, responsavel_id, tipo_acao, acionamento_id, tipo_locomocao, hora, liberacao, tipo_autenticacao) ";
				$sql .= "values (".$veiculo_id.", ".$responsavel_id.", '".$tipo_acao."', 3, '".$tipo_locomocao."', '".$agora."', " . $liberado . ", ".$tipo_autenticacao.");";
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
				
				// COLETANDO DADOS DA EMPRESA
				$sql  = "select e.empresa_id, e.nome from empresa as e ";
				$sql .= "inner join rel_empresa_funcionario as reu on reu.empresa_id = e.empresa_id ";
				$sql .= "inner join usuario as u on u.usuario_id = reu.usuario_id ";
				$sql .= "where u.usuario_id = ".$array_dados_documento['usuario_id'].";";
				$select = mysqli_query($conexao, $sql);
				$array_dados_empresa = mysqli_fetch_array($select);

				// INSERINDO REGISTRO NA TABELA DE RELACIONAMENTO REGISTRO-EMPRESA
				$sql  = "insert into rel_registro_empresa (empresa_id, registro_acesso_id) ";
				$sql .= "values (".$array_dados_empresa['empresa_id'].", ".$array_dados_registro_acesso['registro_acesso_id'].");";
				mysqli_query($conexao, $sql);

				if($responsavel_id == '35'){
					// ENVIANDO NOTIFICAÇÃO
					$registration_ids = array();
					$click_action = "Notificacao";
					$object_in_array = array("registro_acesso" => $array_dados_registro_acesso['registro_acesso_id']);
					$retorno = push_notification($title, $description, $click_action, $object_in_array, $registration_ids);
				}			
			}

		}else{
			$liberado = 0;
			$registro_acesso_id = 0;
			$title = "Acesso negado";
			$description = "O acesso para a pessoa ".$array_dados_documento['nome']." foi negado às ".date('H:m:s');
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