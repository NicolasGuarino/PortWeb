<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();

	$carro_id = "0";
	$placa = "N/E";
	$modelo = "N/E"; 
	$marca = "N/E";
	$cor = "N/E";
	$foto = "N/E";
	$documento_id = "N/E";
	$ativo = "1";
	
	function tratamento_valores($variavel_padrao, $valor){
		
		if($valor == "" || $valor == null){
			$new_var = $variavel_padrao;
		}else{
			$new_var = $valor;
		}


		return $new_var;
	}

	if(isset($_REQUEST['placa'])){
		$placa_veiculo = $_REQUEST['placa'];
		$query = "select v.*, u.nome, u.email, u.telefone, u.data_nascimento, u.ultima_atualizacao, u.foto as foto_usuario from veiculo as v
		left join rel_usuario_veiculo as rel_uv on v.veiculo_id = rel_uv.veiculo_id
		left join usuario as u on u.usuario_id = rel_uv.usuario_id
		where v.placa = '".$placa_veiculo."';";
	}else{
		$usuario_id = $_REQUEST['usuario_id'];

		$query = "select v.*, u.nome, u.email, u.telefone, u.data_nascimento, u.ultima_atualizacao, u.foto as foto_usuario 
					from usuario as u
					left join rel_usuario_veiculo as rel_uv on u.usuario_id = rel_uv.usuario_id
					left join veiculo as v on v.veiculo_id = rel_uv.veiculo_id
					where u.usuario_id = '".$usuario_id."';";
	}

	
	$select = mysqli_query($conexao, $query);
	
	
	while($rs = mysqli_fetch_array($select)){
		$data_nascimento = date("d/m/Y", strtotime($rs['data_nascimento']));
		$ult_atualizacao = date("d/m/Y H:i:s", strtotime($rs['ultima_atualizacao']));
		
		$carro_id = tratamento_valores($carro_id, utf8_encode($rs['veiculo_id']));
		$placa = tratamento_valores($placa ,utf8_encode($rs['placa']));
		$modelo = tratamento_valores($modelo ,utf8_encode($rs['modelo']));
		$marca = tratamento_valores($marca ,utf8_encode($rs['marca']));
		$cor = tratamento_valores($cor ,utf8_encode($rs['cor']));
		$foto = tratamento_valores($foto ,utf8_encode($rs['foto']));
		$documento_id = tratamento_valores($documento_id ,utf8_encode($rs['documento_id']));
		$ativo = tratamento_valores($ativo ,utf8_encode($rs['ativo']));

		$obj_carros = array(
			"id" => $carro_id,
			"placa" => $placa,
			"modelo" => $modelo ,
			"marca" => $marca,
			"cor" => $cor,
			"foto" => $foto,
			"documento_id" => $documento_id,
			"ativo" => $ativo,
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