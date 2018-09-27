<?php
	require_once "conexao.php";	

	$usuario_id = addslashes($_REQUEST['usuario_id']);
	$dia_da_semana = addslashes($_REQUEST['dia_da_semana']);
	$hora_entrada = addslashes($_REQUEST['hora_entrada']);
	$hora_saida = addslashes($_REQUEST['hora_saida']);
	$empresa_id = addslashes($_REQUEST['empresa_id']);

	$conexao = conectar();

	$query  = "insert into escala(usuario_id, dia_da_semana, hora_entrada, hora_saida, empresa_id) ";
	$query .= "values(".$usuario_id.", ".$dia_da_semana.", '".$hora_entrada."', '".$hora_saida."', ".$empresa_id.");";
	$result  = mysqli_query($conexao, $query) or die("Não foi possivel inserir o registro de escala<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

	echo intval($result);
?>