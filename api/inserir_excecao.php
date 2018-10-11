<?php
	require_once "conexao.php";	

	$data = $_REQUEST['data'];
	$hora_entrada = $_REQUEST['hora_entrada'];
	$hora_saida = $_REQUEST['hora_saida'];
	$usuario_id = $_REQUEST['usuario_id'];
	
	
	$new_date = explode("/", $data);
	$dia = $new_date[0];
	$mes = $new_date[1];
	$ano = $new_date[2]; 

	$data = $ano."-".$mes."-".$dia;
	$conexao = conectar();

	$query  = "insert into excessao(data, hora_entrada, hora_saida, usuario_id) ";
	$query .= "values('".$data."', '".$hora_entrada."', '".$hora_saida."', ".$usuario_id.");";
	
	echo $query;
	$result  = mysqli_query($conexao, $query) or die("Não foi possivel inserir o registro de exceção<br/><b>Erro: " . mysqli_error($conexao) . "</b>");
?>