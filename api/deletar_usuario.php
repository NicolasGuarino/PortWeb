<?php
	
	require_once "conexao.php";

	$usuario_id   = $_REQUEST['usuario_id'];
	$conexao = conectar();


	$query = "update usuario set ativo = 0 where usuario_id = ".$usuario_id.";";
	$result  = mysqli_query($conexao, $query) or die("Não foi possivel deletar o registro do usuário<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

	echo intval($result);	
?>