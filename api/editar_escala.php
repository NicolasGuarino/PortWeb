<?php
	require_once "conexao.php";

	date_default_timezone_set('America/Araguaina');
	$conexao = conectar();

	$entrada = $_REQUEST['entrada'];
	$saida = $_REQUEST['saida'];
	$dia = $_REQUEST['dia'];
	$empresa_id = $_REQUEST['empresa_id'];
	$usuario_id = $_REQUEST['usuario_id'];

	if(strpos($dia, "dia")) {
		$query  = "update escala set hora_entrada = '".$entrada."', hora_saida = '".$saida."' where escala_id = ".$dia.";";
		$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));
	}else{
		$dia = substr($dia, strpos($dia, "_") + 1);
		$query  = "insert into escala(usuario_id, dia_da_semana, hora_entrada, hora_saida, empresa_id) ";
		$query .= "values(".$usuario_id.", ".$dia.", '".$entrada."', '".$saida."', ".$empresa_id.");";
		$result  = mysqli_query($conexao, $query) or die("Não foi possivel inserir o registro de escala<br/><b>Erro: " . mysqli_error($conexao) . "</b>");
	}

	
	echo intval($result);

	mysqli_close($conexao);
?>