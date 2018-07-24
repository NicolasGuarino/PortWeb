<?php
	require_once "conexao.php";

	date_default_timezone_set('America/Araguaina');
	$conexao = conectar();

	$usuario_id = $_POST['usuario_id'];
	$nome = $_POST['nome'];
	$cpf = $_POST['cpf'];
	$rg = $_POST['rg'];
	$dt_nascimento = $_POST['dt_nascimento'];
	$documento = $_POST['documento'];
	$tipo_usuario = $_POST['tipo_usuario'];
	@$imagem = $_FILES['imagem'];
	$tel = $_POST['tel'];
	$email = $_POST['email'];
	$atualizarImg = $_POST['atualizarImg'];
	
	

	if($atualizarImg == "true") {
		$caminho = "img/";
		$caminho_upload = "../".$caminho.$imagem['name'];
		$caminho_banco  = $caminho.$imagem['name'];

		if(move_uploaded_file($imagem['tmp_name'], $caminho_upload)) $result = "Upload OK";
		else $result = "Erro upload: " . $imagem['error'];
	}else{
		$caminho_banco = $atualizarImg;
	}

	$query  = "update usuario set nome = '".$nome."', cpf = '".$cpf."', data_nascimento = '".$dt_nascimento."', tipo_usuario_id = ".$tipo_usuario.", documento_id = ".$documento.", ";
	$query .= "foto = '".$caminho_banco."', telefone = '".$tel."', email = '".$email."', ultima_atualizacao = now(), rg = '".$rg."' where usuario_id = ".$usuario_id.";";
	$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));;
	
	echo intval($result);

	mysqli_close($conexao);
?>