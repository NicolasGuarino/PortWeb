<?php
	require_once "conexao.php";

	date_default_timezone_set('America/Araguaina');
	session_start();
	$conexao = conectar();

	$empresa_id = addslashes($_REQUEST['empresa_id']);
	$nome = addslashes($_REQUEST['nome']);
	$telefone = addslashes($_REQUEST['telefone']);
	$email = addslashes($_REQUEST['email']);
	@$imagem = $_FILES['imagem'];
	$atualizarImg = addslashes($_REQUEST['atualizarImg']);
	
	

	if($atualizarImg == "true") {
		$caminho = "img/";
		$caminho_upload = "../".$caminho.$imagem['name'];
		$caminho_banco  = $caminho.$imagem['name'];

		if(move_uploaded_file($imagem['tmp_name'], $caminho_upload)) $result = "Upload OK";
		else $result = "Erro upload: " . $imagem['error'];
	}else{
		$caminho_banco = $atualizarImg;
	}

	$query  = "update empresa set nome = '".$nome."', telefone = '".$telefone."', email = '".$email."', foto = '".$caminho_banco."' where empresa_id = ".$empresa_id.";";
	$exec = mysqli_query($conexao, $query);

	echo intval($exec);
	mysqli_close($conexao);
?>