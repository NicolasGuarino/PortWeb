<?php
	
	require_once "conexao.php";

	$documento_id = addslashes($_REQUEST['documento_id']);
	$usuario_id   = addslashes($_REQUEST['usuario_id']);
	$placa  = addslashes($_REQUEST['placa']);
	$modelo = addslashes($_REQUEST['modelo']);
	$marca  = addslashes($_REQUEST['marca']);
	$cor 	= addslashes($_REQUEST['cor']);
	$foto 	= addslashes($_REQUEST['foto']);

	$conexao = conectar();


	$query   = "insert into veiculo(documento_id, placa, modelo, marca, cor, foto) ";
	$query  .= "values(".$documento_id.", '".$placa."', '".$modelo."', '".$marca."', '".$cor."', '".$foto."');";
	$result  = mysqli_query($conexao, $query) or die("Não foi possivel inserir o registro de veiculo<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

	$query   = "select last_insert_id() as veiculo_id;";
	$select  = mysqli_query($conexao, $query) or die("Não foi possivel recuperar o ultimo id inserido<br/><b>Erro: " . mysqli_error($conexao) . "</b>");
	$rs = mysqli_fetch_array($select);

	$veiculo_id = $rs['veiculo_id'];

	$query   = "insert into rel_usuario_veiculo(usuario_id, veiculo_id) ";
	$query  .= "values(".$usuario_id.", ".$veiculo_id.");";
	$result  = mysqli_query($conexao, $query) or die("Não foi possivel inserir o registro de relacionamento entre o usuario e o veiculo<br/><b>Erro: " . mysqli_error($conexao) . "</b>");
?>






