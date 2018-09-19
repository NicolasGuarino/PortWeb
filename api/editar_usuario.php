<?php
	require_once "conexao.php";

	date_default_timezone_set('America/Araguaina');
	session_start();
	$conexao = conectar();

	$usuario_id = addslashes($_REQUEST['usuario_id']);
	$nome = addslashes($_REQUEST['nome']);
	$cpf = addslashes($_REQUEST['cpf']);
	$rg = addslashes($_REQUEST['rg']);
	$dt_nascimento = addslashes($_REQUEST['dt_nascimento']);
	$empresa = addslashes($_REQUEST['empresa']);
	$tipo_usuario = addslashes($_REQUEST['tipo_usuario']);
	@$imagem = $_FILES['imagem'];
	$tel = addslashes($_REQUEST['tel']);
	$email = addslashes($_REQUEST['email']);
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

<<<<<<< HEAD
	$query  = "update usuario set nome = '".$nome."', cpf = '".$cpf."', data_nascimento = '".$dt_nascimento."', tipo_usuario_id = ".$tipo_usuario.", documento_id = ".$documento.", ";
	$query .= "foto = '".$caminho_banco."', telefone = '".$tel."', email = '".$email."', rg = '".$rg."' where usuario_id = ".$usuario_id.";";
	$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));;
=======
	$query  = "update usuario set nome = '".$nome."', cpf = '".$cpf."', data_nascimento = '".$dt_nascimento."', tipo_usuario_id = ".$tipo_usuario.", ";
	$query .= "foto = '".$caminho_banco."', telefone = '".$tel."', email = '".$email."', rg = '".$rg."' where usuario_id = ".$usuario_id.";";
	$result = mysqli_query($conexao, $query) or die("Erro 35:" . mysqli_error($conexao));

	$query  = "update rel_empresa_funcionario set empresa_id = '".$empresa."' where usuario_id = ".$usuario_id.";";
	$result = mysqli_query($conexao, $query) or die("Erro 38:" . mysqli_error($conexao));
>>>>>>> 32972b86657663c1f2156ea71aaeaee319fb02cf
	
	echo intval($result);

	if($usuario_id == $_SESSION['usuario']['usuario_id']) {
		$query = "select * from usuario as u left join rel_empresa_funcionario as ef on(ef.usuario_id=u.usuario_id) where u.usuario_id = ".$usuario_id.";";
		$select = mysqli_query($conexao, $query);
		$_SESSION['usuario'] = mysqli_fetch_array($select);
	}

	mysqli_close($conexao);
?>