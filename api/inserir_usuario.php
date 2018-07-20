<?php
	require_once "conexao.php";

	date_default_timezone_set('America/Araguaina');
	$conexao = conectar();

	$nome = $_POST['nome'];
	$cpf = $_POST['cpf'];
	$rg = $_POST['rg'];
	$dt_nascimento = $_POST['dt_nascimento'];
	$documento = $_POST['documento'];
	$tipo_usuario = $_POST['tipo_usuario'];
	$imagem = $_FILES['imagem'];
	$tel = $_POST['tel'];
	$email = $_POST['email'];
	
	$caminho = "img/";
	$caminho_upload = "../".$caminho.$imagem['name'];
	$caminho_banco  = $caminho.$imagem['name'];;

	if(move_uploaded_file($imagem['tmp_name'], $caminho_upload)) {
		$query  = "insert into usuario(nome, cpf, data_nascimento, tipo_usuario_id, documento_id, foto, telefone, email, ultima_atualizacao, rg) ";
		$query .= "values('".$nome."', '".$cpf."', '".$dt_nascimento."', ".$tipo_usuario.", ".$documento.", '".$caminho_banco."', '".$tel."', '".$email."', now(), '".$rg."');";

		$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));;
	}else{
		$result = "Erro upload: " . $imagem['error'];
	}
	
	echo intval($result);

	mysqli_close($conexao);
?>