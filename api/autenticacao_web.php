<?php
	// session_save_path("/tmp");
	session_start();
	include("conexao.php");

	$con = conectar();
	$res = ["valor" => null, "pagina" => null];

	$usuario   	 = $_REQUEST['usuario'];
	$senha 	   	 = sha1($_REQUEST['senha']);
	$ip 	   	 = $_SERVER['REMOTE_ADDR'];
	$resultado 	 = 0;

	$query = "call autenticacao('".$senha."', '".$usuario."');";
	$sucesso = mysqli_query($con, $query);
	$rs = mysqli_fetch_array($sucesso);

	// Verificando se o Usuário Existe
	if(isset($rs['nome'])){ // Se Existir
		$res =  ["valor" => true, "nome" => $rs['nome']];
		$_SESSION['usuario'] = $rs;
	}else{
		$res = ["valor" => false, "nome" => null];
	}

	$json = json_encode($res);
	echo($json);
?>