<?php
	require_once "conexao.php";

	date_default_timezone_set('America/Araguaina');
	$conexao = conectar();

	$escala_id = $_REQUEST['escala_id'];

	$query  = "delete from escala where escala_id = ".$escala_id.";";
	$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));

	
	echo intval($result);

	mysqli_close($conexao);
?>