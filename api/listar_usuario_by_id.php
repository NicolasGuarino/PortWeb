<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();

	$rg = $_GET['rg'];

	$query = "select u.* from usuario as u inner join documento as d on(d.documento_id=u.documento_id) 
			  where u.rg like'%".$rg."' limit 1";

			 //echo($query);

	$select = mysqli_query($conexao, $query);
 
	$cont = 0;
	

		while($rs = mysqli_fetch_array($select)){
			$obj_retorno[$cont] = array(
				"usuario_id" => utf8_encode($rs['usuario_id']),
				"nome" => utf8_encode($rs['nome']),
				"tipo_usuario_id" => utf8_encode($rs['tipo_usuario_id']),
				"documento_id" => utf8_encode($rs['documento_id']),
				"ultima_atualizacao" => $rs['ultima_atualizacao'],
				"rg" => utf8_encode($rs['rg']),
				"foto_usuario" => utf8_encode($rs['foto']),
				"telefone" => utf8_encode($rs['telefone']),
				"email" => utf8_encode($rs['email']),
			);		

			$cont++;
		
	}

	echo json_encode($obj_retorno, JSON_UNESCAPED_UNICODE);
?>