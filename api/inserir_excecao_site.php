<?php
	require_once "conexao.php";	

	$data = $_REQUEST['data'];
	$hora_entrada = $_REQUEST['hora_entrada'];
	$hora_saida = $_REQUEST['hora_saida'];
	$usuario_id = $_REQUEST['usuario_id'];

	$conexao = conectar();

	$query  = "insert into excessao(data, hora_entrada, hora_saida, usuario_id) ";
	$query .= "values('".$data."', '".$hora_entrada."', '".$hora_saida."', ".$usuario_id.");";
	$result  = mysqli_query($conexao, $query) or die("Não foi possivel inserir o registro de exceção<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

	echo intval($result);
?>