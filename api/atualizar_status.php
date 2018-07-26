<?php 
	date_default_timezone_set('America/Araguaina');
	include "conexao.php";

	$con = conectar();

	$status     = $_REQUEST['status'];
	$usuario_id = $_REQUEST['usuario_id'];


	$hora = date('Y-m-d H:i:s');
	$query = "insert into rel_status_usuario(status_id, usuario_id, hora) values(".$status.", ".$usuario_id.", '".$hora."');";
	$result = mysqli_query($con, $query) or die(mysqli_error($con));

	$query = "update usuario set ultima_atualizacao = '".$hora."' where usuario_id = ".$usuario_id.";";
	$result = mysqli_query($con, $query) or die(mysqli_error($con));

	echo intval($result);
?>