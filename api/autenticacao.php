<?php
	session_save_path("/tmp");
	//session_start();
	include("conexao.php");

	$con = conectar();
	$res = ["valor" => null, "pagina" => null];

	$usuario   	 = $_REQUEST['usuario'];
	$senha 	   	 = sha1($_REQUEST['senha']);
	$ip 	   	 = $_SERVER['REMOTE_ADDR'];
	$resultado 	 = 0;

	//$query = "call login('".$usuario."', '".$senha."', '".$ip."', @resultado);";
	$query  = "select * from usuario as u ";
	$query .= "inner join rel_empresa_funcionario as ef on(ef.usuario_id=u.usuario_id) ";
	$query .= "inner join empresa as e on(e.empresa_id=ef.empresa_id) ";
	$query .= "where senha = '".$senha."' and login = '".$usuario."';";
	//$sucesso = mysqli_query($con, $query);

//echo($query);
	//$query 	 = "select @resultado;";
	$retorno = mysqli_query($con, $query);

	$rs = mysqli_fetch_array($retorno);
	$resultado = $rs['usuario_id'];

	// Verificando se o Usuário Existe
	if($resultado != null){ // Se Existir
		$res =  ["valor" => true, 
				"nome" => $rs['nome'],
				"tipo_usuario" => $rs['tipo_usuario_id'],
				"usuario_id" => $rs['usuario_id'],
				"empresa_id" => $rs['empresa_id']
				];
		//$res = "true";
	
	}else{
		$res = ["valor" => false, "nome" => null];
		//$res = "false";
	}

	$json = json_encode($res);
	echo($json);
?>