<?php
	// if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) {
	include 'conexao.php';

	$usuario = "";
	$senha = "";
	
	if(isset($_GET['email'])){

		$usuario = addslashes($_GET['email']);
		$senha = addslashes($_GET['senha']);
		$lista = array();

		$sql = "call autenticar('".$usuario."','".$senha."')";
		
		$select = mysqli_query($conecta,$sql);
		$array = mysqli_fetch_array($select);
		mysqli_close($conecta);
		$lista = array();

		if($array['tipo_usuario_id'] == '1'){

			if ($array['aguardando_liberacao'] == '1') {

				$conecta2 = conectar();

				$sql_responsavel_empresa = "call enviar_email_p_proprietario_id(".$array['proprietario_id_temp'].");";
				$select_responsavel_empresa = mysqli_query($conecta2, $sql_responsavel_empresa);
				$array_empresa = mysqli_fetch_array($select_responsavel_empresa);
				$email_empresa = $array_empresa['email_empresa'];
				mysqli_close($conecta2);
			}else{
				$email_empresa = '';
			}

			$lista[0] = array(
			"id_pessoa" => $array['usuario_id'],
			"email" => $array['email'],
			"email_empresa" => $email_empresa,
			"nome" => utf8_encode($array['nome']),
			"senha" => '',
			"celular" => $array['celular'],
			"cnpj" => '',
			"sexo" => $array['sexo'],
			"data_nascimento" => $array['dt_nascimento'],
			"proprietario_id" => '',
			"proprietario_id" => '',
			"hierarquia_usuario" => $array['tipo_usuario_id'],
			"bloqueio" => $array['bloqueio'],
			"aguardando_liberacao" => $array['aguardando_liberacao'],
			"proprietario_id_temp" => $array['proprietario_id_temp'],
			"resultado" => $array['resultado']
			);
		}else if($array['tipo_usuario_id'] == '2'){

			$lista[0] = array(
			"id_pessoa" => $array['usuario_id'],
			"email" => $array['email'],
			"email_empresa" => $array['email_empresa'],
			"nome" => utf8_encode($array['nome']),
			"senha" => '',
			"celular" => $array['celular'],
			"cnpj" => utf8_encode($array['cnpj']),
			"sexo" => $array['sexo'],
			"data_nascimento" => $array['dt_nascimento'],
			"proprietario_id" => utf8_encode($array['proprietario_id']),
			"informacoes_empresa_id" => utf8_encode($array['informacoes_empresa_id']),
			"hierarquia_usuario" => $array['tipo_usuario_id'],
			"nome_empresa" => $array['nome_empresa'],
			"bloqueio" => $array['bloqueio'],
			"resultado" => $array['resultado']
			);


		}else if($array['tipo_usuario_id'] == '3'){
			$lista[0] = array(
			"id_pessoa" => $array['usuario_id'],
			"email" => $array['email'],
			"email_empresa" => '',
			"nome" => utf8_encode($array['nome']),
			"senha" => '',
			"celular" => $array['celular'],
			"cnpj" => '',
			"sexo" => $array['sexo'],
			"data_nascimento" => $array['dt_nascimento'],
			"proprietario_id" => utf8_encode($array['proprietario_id']),
			"informacoes_empresa_id" => utf8_encode($array['informacoes_empresa_id']),
			"hierarquia_usuario" => $array['tipo_usuario_id'],
			"bloqueio" => $array['bloqueio'],
			"resultado" => $array['resultado']
			);
		}else if($array['tipo_usuario_id'] == '4'){
			$lista[0] = array(
			"id_pessoa" => $array['usuario_id'],
			"email" => $array['email'],
			"email_empresa" => '',
			"nome" => utf8_encode($array['nome']),
			"senha" => '',
			"celular" => $array['celular'],
			"cnpj" => '',
			"sexo" => $array['sexo'],
			"data_nascimento" => $array['dt_nascimento'],
			"proprietario_id" => '',
			"hierarquia_usuario" => $array['tipo_usuario_id'],
			"bloqueio" => $array['bloqueio'],
			"resultado" => $array['resultado']
			);
		}else if($array['tipo_usuario_id'] == '12'){
			$lista[0] = array(
			"id_pessoa" => $array['usuario_id'],
			"email" => $array['email'],
			"email_empresa" => '',
			"nome" => utf8_encode($array['nome']),
			"senha" => '',
			"celular" => $array['celular'],
			"cnpj" => '',
			"sexo" => $array['sexo'],
			"data_nascimento" => $array['dt_nascimento'],
			"proprietario_id" => '',
			"hierarquia_usuario" => $array['tipo_usuario_id'],
			"bloqueio" => $array['bloqueio'],
			"resultado" => $array['resultado']
			);
		}else{
			$lista[0] = array(
			"id_pessoa" => '',
			"email" => '',
			"email_empresa" => '',
			"nome" => '',
			"senha" => '',
			"celular" => '',
			"cnpj" => '',
			"sexo" => '',
			"data_nascimento" => '',
			"proprietario_id" => '',
			"hierarquia_usuario" => '',
			"bloqueio" => '',
			"resultado" => '0'
			);
		}

		echo json_encode($lista[0]);
	} 
// }
?>

