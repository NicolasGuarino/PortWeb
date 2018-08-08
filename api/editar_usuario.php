<?php
	require_once "conexao.php";

	date_default_timezone_set('America/Araguaina');
	session_start();
	$conexao = conectar();

	$usuario_id = $_REQUEST['usuario_id'];
	$nome = $_REQUEST['nome'];
	$cpf = $_REQUEST['cpf'];
	$rg = $_REQUEST['rg'];
	$dt_nascimento = $_REQUEST['dt_nascimento'];
	$empresa = $_REQUEST['empresa'];
	$tipo_usuario = $_REQUEST['tipo_usuario'];
	@$imagem = $_FILES['imagem'];
	$tel = $_REQUEST['tel'];
	$email = $_REQUEST['email'];
	$atualizarImg = $_REQUEST['atualizarImg'];
	
	

	if($atualizarImg == "true") {
		$caminho = "img/";
		$caminho_upload = "../".$caminho.$imagem['name'];
		$caminho_banco  = $caminho.$imagem['name'];

		if(move_uploaded_file($imagem['tmp_name'], $caminho_upload)) $result = "Upload OK";
		else $result = "Erro upload: " . $imagem['error'];
	}else{
		$caminho_banco = $atualizarImg;
	}

	$query  = "update usuario set nome = '".$nome."', cpf = '".$cpf."', data_nascimento = '".$dt_nascimento."', tipo_usuario_id = ".$tipo_usuario.", ";
	$query .= "foto = '".$caminho_banco."', telefone = '".$tel."', email = '".$email."', rg = '".$rg."' where usuario_id = ".$usuario_id.";";
	$result = mysqli_query($conexao, $query) or die("Erro 35:" . mysqli_error($conexao));

	$query  = "update rel_empresa_funcionario set empresa_id = '".$empresa."' where usuario_id = ".$usuario_id.";";
	$result = mysqli_query($conexao, $query) or die("Erro 38:" . mysqli_error($conexao));
	
	echo intval($result);

	if($usuario_id == $_SESSION['usuario']['usuario_id']) {
		$query = "select * from usuario where usuario_id = ".$usuario_id.";";
		$select = mysqli_query($conexao, $query);
		$_SESSION['usuario'] = mysqli_fetch_array($select);
	}

	mysqli_close($conexao);
?>