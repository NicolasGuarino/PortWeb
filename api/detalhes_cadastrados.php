<?php  
	
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	// mysqli_set_c

	if(isset($_GET['usuario_id'])){

		$usuario_id = $_GET['usuario_id'];

		// $registro_acesso_obj = array();

		$conexao = conectar();
		/*$sql = "select 
				r.registro_acesso_id, 
				u.usuario_id, 
				u.nome as nome_usuario, 
				u.foto as foto_usuario, 
				e.nome as nome_empresa, 
				e.foto as foto_empresa  
				from registro_acesso as r 
				inner join rel_registro_usuario as ru on ru.registro_acesso_id = r.registro_acesso_id 
				inner join usuario as u on ru.usuario_id = u.usuario_id 
				inner join rel_registro_empresa as re on r.registro_acesso_id = re.registro_acesso_id 
				inner join empresa as e on e.empresa_id = re.empresa_id 
				where r.registro_acesso_id = ".$registro_acesso_id." limit 1;";

		$select = mysqli_query($conexao, $sql);
		$array_dados_registro = mysqli_fetch_array($select);

		array_push($registro_acesso_obj, "registro_acesso_id" => $array_dados_registro['registro_acesso_id']);
		array_push($registro_acesso_obj, "usuario_id"=> $array_dados_registro['usuario_id']);
		array_push($registro_acesso_obj, "nome_usuario"=> $array_dados_registro['nome_usuario']);
		array_push($registro_acesso_obj, "foto_usuario"=> $array_dados_registro['foto_usuario']);
		array_push($registro_acesso_obj, "nome_empresa"=> $array_dados_registro['nome_empresa']);
		array_push($registro_acesso_obj, "foto_empresa"=> $array_dados_registro['foto_empresa']);

		mysqli_close($conexao);


		$array_escala = array();
		$conexao = conectar();
		$sql = "select * from escala where usuario_id = ".$array_dados_registro['usuario_id'].";";
		$select = mysqli_query($conexao, $sql);
		while($array_dados_escala = mysqli_fetch_array($select)){

			$item = array("dia_da_semana"=>$array_dados_escala['dia_da_semana'], 
				"hora_entrada"=>$array_dados_escala['hora_entrada'], 
				"hora_saida"=>$array_dados_escala['hora_saida']);

			array_push($array_escala,$item);

		}

		array_push($registro_acesso_obj, "escala_obj"=> $array_escala);
		mysqli_close($conexao);

		$array_excessao = array();
		$conexao = conectar();
		$sql = "select * from excessao where usuario_id = ".$array_dados_registro['usuario_id'].";";
		$select = mysqli_query($conexao, $sql);
		while($array_dados_escala = mysqli_fetch_array($select)){

			$item = array("data"=>$array_dados_escala['data'], 
				"hora_entrada"=>$array_dados_escala['hora_entrada'], 
				"hora_saida"=>$array_dados_escala['hora_saida']);

			array_push($array_excessao,$item);

		}

		array_push($registro_acesso_obj, "excessao_obj"=> $array_excessao);
		mysqli_close($conexao);*/

		$query = "select v.foto as foto_carro, CONCAT(v.marca, ' ', v.modelo, ',', v.cor) as carro, v.placa, u.foto as foto_usuario, u.usuario_id, u.nome as nome, u.email, u.rg ";/*, e.nome as empresa ";*/
		$query .= "from usuario as u ";
		//$query .= "inner join rel_empresa_funcionario as ef on(ef.usuario_id=u.usuario_id) ";
	//	$query .= "inner join empresa as e on(e.empresa_id=ef.empresa_id) ";
		$query .= "left join rel_usuario_veiculo as uv on(uv.usuario_id=u.usuario_id) ";
		$query .= "left join veiculo as v on(v.veiculo_id=uv.veiculo_id) ";
		$query .= "where u.usuario_id = " . $usuario_id . " limit 1; ";

		//echo($query);

		$select = mysqli_query($conexao, $query);
		$rs = mysqli_fetch_array($select);

		// $usuario = $rs['usuario'];

		$obj_retorno = array(
			"foto_carro" => utf8_encode($rs['foto_carro']),
			"carro"  => utf8_encode($rs['carro']),
			"placa" => utf8_encode($rs['placa']),
			"foto_usuario" => utf8_encode($rs['foto_usuario']),
			"nome" => utf8_encode($rs['nome']),
			"usuario_id" => utf8_encode($rs['usuario_id']),
			"rg" => utf8_encode($rs['rg']),
			"email" => utf8_encode($rs['email'])
		);

		echo json_encode($obj_retorno, JSON_UNESCAPED_UNICODE);

	}

?>