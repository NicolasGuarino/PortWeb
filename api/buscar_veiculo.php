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

	$dia_da_semana = "";
	$hora_entrada = "";
	$hora_saida = "";
	$empresa = "Não Informado";
	$dia_excessao = "";
	$hora_entrada_excessao = "";
	$hora_saida_excessao = "";
	$telefone_empresa = "Não Informado";
	$email_responsavel = "Não Informado";
	
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
		$query = "select v.*, u.nome, u.email, u.telefone, u.data_nascimento, u.ultima_atualizacao, u.foto as foto_usuario,
		IF( weekday(now()) = '0', 'Segunda-feira', 
			if( weekday(now()) = '1', 'Terça-feira', 
				if( weekday(now()) = '2', 'Quarta-feira', 
					if( weekday(now()) = '3', 'Quinta-feira', 
						if( weekday(now()) = '4', 'Sexta-feira', 
							if( weekday(now()) = '5', 'Sábado', 
								if( weekday(now()) = '6', 'Domingo', 'Dia não encontrado'))))))) as dia_da_semana,
						
						e.hora_entrada,
						e.hora_saida,
						emp.nome AS empresa,
						emp.telefone as telefone_empresa,
						emp.email as email_responsavel,
						date_format(ex.data, '%d/%m/%Y') as dia_excessao,
						ex.hora_entrada as hora_entrada_excessao,
						ex.hora_saida as hora_saida_excessao
						
						from usuario as u
						left join rel_usuario_veiculo as rel_uv on u.usuario_id = rel_uv.usuario_id
						left join rel_empresa_funcionario as rel_ef on rel_ef.usuario_id = u.usuario_id
						left join empresa as emp on emp.empresa_id = rel_ef.empresa_id
						left join veiculo as v on v.veiculo_id = rel_uv.veiculo_id
						left join escala as e on e.usuario_id = u.usuario_id
						left join excessao as ex on ex.usuario_id = u.usuario_id
						where v.placa = '".$placa_veiculo."'  limit 1;";
	}else{
		$usuario_id = $_REQUEST['usuario_id'];

		$query = "select v.*, u.nome, u.email, u.telefone, u.data_nascimento, u.ultima_atualizacao, u.foto as foto_usuario,
					IF( weekday(now()) = '0',
						'Segunda-feira',
						IF( weekday(now()) = '1',
							'Terça-feira',
							IF( weekday(now()) = '2',
								'Quarta-feira',
								IF( weekday(now()) = '3',
									'Quinta-feira',
									IF( weekday(now()) = '4',
										'Sexta-feira',
										IF( weekday(now()) = '5',
											'Sábado',
											IF( weekday(now()) = '6',
												'Domingo',
												'Dia não encontrado'))))))) AS dia_da_semana,  
												
												e.hora_entrada,
												e.hora_saida,
												emp.nome AS empresa,
												emp.telefone as telefone_empresa,
												emp.email as email_responsavel,
												date_format(ex.data, '%d/%m/%Y') as dia_excessao,
												ex.hora_entrada as hora_entrada_excessao,
												ex.hora_saida as hora_saida_excessao
												from usuario as u
												left join rel_usuario_veiculo as rel_uv on u.usuario_id = rel_uv.usuario_id
												left join rel_empresa_funcionario as rel_ef on rel_ef.usuario_id = u.usuario_id
												left join empresa as emp on emp.empresa_id = rel_ef.empresa_id
												left join veiculo as v on v.veiculo_id = rel_uv.veiculo_id
												LEFT JOIN escala AS e ON e.usuario_id = u.usuario_id
												left join excessao as ex on ex.usuario_id = u.usuario_id
								where u.usuario_id = '".$usuario_id."' limit 1;";
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

		$dia_da_semana = tratamento_valores($dia_da_semana, utf8_encode($rs['dia_da_semana']));
		$hora_entrada = tratamento_valores($hora_entrada, utf8_encode($rs['hora_entrada']));
		$hora_saida = tratamento_valores($hora_saida, utf8_encode($rs['hora_saida']));
		$empresa = tratamento_valores($empresa, utf8_encode($rs['empresa']));
		$dia_excessao = tratamento_valores($dia_excessao, utf8_encode($rs['dia_excessao'])); 
		$hora_entrada_excessao = tratamento_valores($hora_entrada_excessao, utf8_encode($rs['hora_entrada_excessao'])); 
		$hora_saida_excessao = tratamento_valores($hora_saida_excessao, utf8_encode($rs['hora_saida_excessao'])); 

		$telefone_empresa = tratamento_valores($telefone_empresa, utf8_encode($rs['telefone_empresa'])); 
		$email_responsavel = tratamento_valores($email_responsavel, utf8_encode($rs['email_responsavel'])); 

		if($dia_excessao != null || $dia_excessao != ""){
			$dia_escala = $dia_excessao;
			$hora_entrada_escala = $hora_entrada_excessao;
			$hora_saida_escala = $hora_saida_excessao;
		}else{
			$dia_escala = $dia_da_semana;
			$hora_entrada_escala = $hora_entrada;
			$hora_saida_escala = $hora_saida;
		}

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
			"foto_usuario" => $rs['foto_usuario'],
			"dia_da_semana" => $dia_escala,
			"hora_entrada" => $hora_entrada_escala,
			"hora_saida" => $hora_saida_escala,
			"empresa" => $empresa,
			"telefone_empresa" => $telefone_empresa,
			"email_empresa" => $email_responsavel		
		);		
	}

	echo json_encode($obj_carros, JSON_UNESCAPED_UNICODE);

?>