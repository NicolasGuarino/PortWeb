<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();

	$placa_veiculo = $_REQUEST['placa'];

	$query = "select v.*, u.nome, u.email, u.telefone, u.data_nascimento, u.ultima_atualizacao, u.foto as foto_usuario from veiculo as v
			left join usuario as u
			on u.documento_id = v.documento_id where v.placa = '".$placa_veiculo."';";
			
	$select = mysqli_query($conexao, $query);
	
	
	while($rs = mysqli_fetch_array($select)){
		$data_nascimento = date("d/m/Y", strtotime($rs['data_nascimento']));
		$ult_atualizacao = date("d/m/Y H:i:s", strtotime($rs['ultima_atualizacao']));

		$obj_carros = array(
			"id" => utf8_encode($rs['veiculo_id']),
			"placa" => utf8_encode($rs['placa']),
			"modelo" => utf8_encode($rs['modelo']),
			"marca" => $rs['marca'],
			"cor" => utf8_encode($rs['cor']),
			"foto" => utf8_encode($rs['foto']),
			"documento_id" => utf8_encode($rs['documento_id']),
			"ativo" => utf8_encode($rs['ativo']),
			"nome" => utf8_encode($rs['nome']),
			"email" => utf8_encode($rs['email']),
			"telefone" => $rs['telefone'],
			"data_nascimento" => $data_nascimento,
			"ultima_atualizacao" => $ult_atualizacao,
			"foto_usuario" => $rs['foto_usuario']
		);		
	}

	echo json_encode($obj_carros, JSON_UNESCAPED_UNICODE);

?>