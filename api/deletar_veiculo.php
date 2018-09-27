<?php
	
	require_once "conexao.php";

	$veiculo_id   = $_REQUEST['veiculo_id'];
	$conexao = conectar();


	$query = "update veiculo set ativo = 0 where veiculo_id = ".$veiculo_id.";";
	$result  = mysqli_query($conexao, $query) or die("Não foi possivel deletar o registro de veiculo<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

	echo intval($result);	
?>