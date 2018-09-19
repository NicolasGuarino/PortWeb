<?php 
	require_once "conexao.php";

	$con = conectar();

	$empresa_id = $_REQUEST['empresa_id'];

	$query = "update empresa set ativo = 0 where empresa_id = ".$empresa_id.";";
	$exec  = mysqli_query($con, $query) or die("Erro 1: " . mysqli_error($con));

	if(intval($exec)) {
		$query  = "select * from rel_empresa_funcionario where empresa_id = ".$empresa_id.";";
		$result = mysqli_query($con, $query) or die("Erro 2: " . mysqli_error($con));

		$query_usuario = "update usuario set ativo = 0 where ";
		
		while ($rs = mysqli_fetch_array($result)) {
			$query_usuario .= "usuario_id = ".$rs['usuario_id']." or ";
		}

		$query_usuario = substr_replace($query_usuario, ";", strlen($query_usuario)-4).";";
		$exec = mysqli_query($con, $query_usuario) or die("Erro 3: " . mysqli_error($con));

		echo intval($exec);
	}
?>