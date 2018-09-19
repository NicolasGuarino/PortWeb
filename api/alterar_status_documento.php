<?php 
	require_once 'conexao.php';
	date_default_timezone_set('America/Araguaina');

	$con = conectar();

	$status = $_REQUEST['status'];
	$documento_id = $_REQUEST['documento_id'];
	$hora = date('Y-m-d H:i:s');

	$query  = "insert into rel_status_documento(status_documento_id, documento_id, hora) values(".$status.", ".$documento_id.", '".$hora."');";
	$result = mysqli_query($con, $query) or die(mysqli_error($con));

	if(intval($result)) {
		$query = "update documento set ultima_atualizacao = '".$hora."' where documento_id = ".$documento_id.";";
		$result = mysqli_query($con, $query) or die(mysqli_error($con));

		echo intval($result);
	}
?>

