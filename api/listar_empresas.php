<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');
	session_start();

	$conexao = conectar();

	$empresa_id = $_REQUEST['empresa_id'];

	$query   = "select * from empresa where empresa_id > ".$empresa_id." and ativo = 1;";
	$result	 = mysqli_query($conexao, $query);

	$lista_empresa = [];
	while($rs=mysqli_fetch_array($result)) $lista_empresa[] = $rs;

	echo json_encode($lista_empresa);

?>