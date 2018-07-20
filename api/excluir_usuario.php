<?php
	require_once "conexao.php";

	date_default_timezone_set('America/Araguaina');
	$conexao = conectar();

	$id = $_REQUEST['id'];
	
	$query = "delete from escala where usuario_id = ".$id.";";
	$query .= "delete from rel_empresa_funcionario where usuario_id = ".$id.";";
	$query .= "delete from rel_status_usuario where usuario_id = ".$id.";";
	$query .= "delete from rel_usuario_veiculo where usuario_id = ".$id.";";
	$query .= "delete from usuario where usuario_id = ".$id.";";

	$result = mysqli_multi_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));;
	
	echo intval($result);

	mysqli_close($conexao);
?>