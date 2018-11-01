<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');
	session_start();

	$conexao = conectar();

	$usuario_id = $_REQUEST['usuario_id'];
	$empresa_id = $_REQUEST['empresa_id'];
	$filtrar    = $_REQUEST['filtrar'];

	// $query = "select * from usuario as u inner join documento as d on(d.documento_id=u.documento_id) where usuario_id > ".$usuario_id." group by d.documento_id order by d.documento_id desc;";
	$filtro_empresa = "";
	if($_SESSION['usuario']['tipo_usuario_id'] != 8 || $filtrar == "true") $filtro_empresa = "and ef.empresa_id = ".$empresa_id;

	$query   = "select * from usuario as u inner join documento as d on(d.documento_id=u.documento_id) ";
	$query  .= "inner join rel_status_usuario as su on(su.usuario_id=u.usuario_id) ";
	$query  .= "inner join rel_empresa_funcionario as ef on(ef.usuario_id=u.usuario_id) ";
	$query  .= "where u.usuario_id > ".$usuario_id." and u.ativo = 1 ".$filtro_empresa." group by d.documento_id order by u.usuario_id desc;";
	
	$select = mysqli_query($conexao, $query);
	
	$cont = 0;

	while($rs = mysqli_fetch_array($select)){
		$obj_retorno[$cont] = array(
			"usuario_id" => utf8_encode($rs['usuario_id']),
			"nome" => $rs['nome'],
			"tipo_usuario_id" => utf8_encode($rs['tipo_usuario_id']),
			"documento_id" => utf8_encode($rs['documento_id']),
			"ultima_atualizacao" => $rs['ultima_atualizacao'],
			"data_nascimento" => utf8_encode($rs['data_nascimento']),
			"foto" => utf8_encode($rs['foto']),
			"telefone" => utf8_encode($rs['telefone']),
			"email" => utf8_encode($rs['email']),
			"rg" => utf8_encode($rs['rg']),
			"cpf" => utf8_encode($rs['cpf'])
		);		

		$cont++;
	}


	echo json_encode($obj_retorno);

?>