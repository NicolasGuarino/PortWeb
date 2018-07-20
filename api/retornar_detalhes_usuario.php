<?php
	require_once "conexao.php";

	$conexao = conectar();
	$lst_usuario = [];
	$lst_escala = [];
	$usuario = null;

	$usuario_id = $_REQUEST['usuario_id'];

	$query  = "select *,u.usuario_id as id, u.foto as foto, TIME_FORMAT(e.hora_entrada, '%H:%i') as hora_entrada, TIME_FORMAT(e.hora_saida,'%H:%i') as hora_saida ";
	$query .= "from usuario as u left join rel_usuario_veiculo as uv on (uv.usuario_id=u.usuario_id) ";
	$query .= "left join veiculo as v on(v.veiculo_id=uv.veiculo_id) ";
	$query .= "left join escala as e on(e.usuario_id=u.usuario_id) where u.usuario_id = ".$usuario_id.";";
	$select = mysqli_query($conexao, $query);
	
	while($rs = mysqli_fetch_array($select)) {


		if($rs['dia_da_semana'] != null) {
			$escala = $arrayName = array('dia' => $rs['dia_da_semana'], 'horario'=> $rs['hora_entrada'] . " - " . $rs['hora_saida']);
			$lst_escala[] = $escala;
		}

		$veiculo = $rs['placa'].",".$rs['marca'];
		$veiculo = ($veiculo != ",") ? $veiculo : null;
		
		$usuario = array
		(
			"usuario_id" => $rs['id'],
			"img" => $rs['foto'],
			"nome" => $rs['nome'],
			"cpf" => $rs['cpf'],
			"email" => $rs['email'],
			"veiculo" => $veiculo,
			"escala" => json_encode($lst_escala)
		);

	}

	$lst_usuario[] = $usuario;

	echo json_encode($lst_usuario[0]);
	mysqli_close($conexao);
?>