<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();

	$query = "select e.*, u.nome, u.foto from excessao as e inner join usuario as u on (u.usuario_id = e.usuario_id) limit 10";

			//inner join rel_empresa_funcionario as ef on(ef.usuario_id=u.usuario_id) 
			//inner join empresa as e on(e.empresa_id=ef.empresa_id) 
	$select = mysqli_query($conexao, $query);
 
	$cont = 0;
	

		while($rs = mysqli_fetch_array($select)){
			$obj_retorno[$cont] = array(
				"data" => utf8_encode($rs['data']),
				"hora_entrada" => utf8_encode($rs['hora_entrada']),
				"hora_saida" => utf8_encode($rs['hora_saida']),
				"nome" => utf8_encode($rs['nome']),
				"foto" => utf8_encode($rs['foto']),
			);		

			$cont++;
		
	}

	echo json_encode($obj_retorno, JSON_UNESCAPED_UNICODE);
?>