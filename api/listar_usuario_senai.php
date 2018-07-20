<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();

	$usuario_id = $_REQUEST['usuario_id'];

	$query = "select * from usuario as u inner join documento as d on(d.documento_id=u.documento_id) where usuario_id > ".$usuario_id." group by d.documento_id order by d.documento_id desc;";
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
			"rg" => utf8_encode($rs['rg'])
		);		

		$cont++;
	}


	echo json_encode($obj_retorno);

?>