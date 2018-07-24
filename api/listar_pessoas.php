<?php

		include 'conexao.php';

		header("Content-Type: text/html; charset=UTF-8", true);
		ini_set('default_charset', 'UTF-8');

		$conexao = conectar();
		
		$where = "";
		if(isset($_GET['filtro'])){
			$filtro = $_GET['filtro'];
			$where = " and (u.nome like '%".$filtro."%' or date_format(r.hora, '%d/%m/%y') like '%".$filtro."%') ";
		}

		if (isset($_GET['filtro_data'])) {
			date_default_timezone_set('America/Sao_Paulo');
			$data_hoje = date('d/m/y');
			$semana_passada = date('Y/m/d', strtotime('-7 days'));;

			if ($_GET['filtro_data'] == "hoje") {
				$where = " and date_format(r.hora, '%d/%m/%y') like '%".$data_hoje."%' ";

			}else {
				$where = " and r.hora> '".$semana_passada."' ";
			}

		}
		/*$query = "select distinct u.usuario_id, r.registro_acesso_id, v.foto as foto_carro, CONCAT(v.marca, ' ', v.modelo, ',', v.cor) as carro, v.placa, u.foto as foto_usuario, u.nome as usuario, e.nome as empresa, r.liberacao,date_format(r.hora, '%d/%m/%y') as data, date_format(r.hora, '%H:%i:%s') as hora , r.tipo_acao, r.tipo_locomocao, u.documento_id as documento_pessoa, u.usuario_id
					from registro_acesso as r 
					inner join rel_registro_usuario as ru on(ru.registro_acesso_id=r.registro_acesso_id) 
					inner join usuario as u on(u.usuario_id=ru.usuario_id)
					inner join rel_empresa_funcionario as ef on(ef.usuario_id=u.usuario_id) 
					inner join empresa as e on(e.empresa_id=ef.empresa_id) 
					left join rel_usuario_veiculo as uv on(uv.usuario_id=ru.usuario_id) 
					left join veiculo as v on(v.veiculo_id=uv.veiculo_id) where r.responsavel_id = 34 and isNull(v.veiculo_id)
					group by u.usuario_id order by r.registro_acesso_id desc;";*/

		$query = "select distinct u.usuario_id, r.registro_acesso_id, v.foto as foto_carro, CONCAT(v.marca, ' ', v.modelo, ',', v.cor) as carro, v.placa, u.foto as foto_usuario, u.nome as usuario, e.nome as empresa, r.liberacao,date_format(r.hora, '%d/%m/%y') as data, date_format(r.hora, '%H:%i:%s') as hora , r.tipo_acao, r.tipo_locomocao, u.documento_id as documento_pessoa, u.usuario_id
					from registro_acesso as r 
					inner join rel_registro_usuario as ru on(ru.registro_acesso_id=r.registro_acesso_id) 
					inner join usuario as u on(u.usuario_id=ru.usuario_id)
					inner join rel_empresa_funcionario as ef on(ef.usuario_id=u.usuario_id) 
					inner join empresa as e on(e.empresa_id=ef.empresa_id) 
					left join rel_usuario_veiculo as uv on(uv.usuario_id=ru.usuario_id) 
					left join veiculo as v on(v.veiculo_id=uv.veiculo_id) where r.responsavel_id = 34 and isNull(v.veiculo_id) ".$where." 
					group by u.usuario_id order by (select r.hora from usuario as us inner join rel_registro_usuario as ru on(ru.usuario_id=us.usuario_id) inner join registro_acesso as r on(r.registro_acesso_id=ru.registro_acesso_id) where us.usuario_id = u.usuario_id and r.responsavel_id=34 order by r.hora desc limit 1) desc;";
		$cont = 0;

		$select = mysqli_query($conexao, $query);
			
		while($rs = mysqli_fetch_array($select)){

			$obj_retorno[$cont] = array(
				"registro_acesso_id" => $rs['registro_acesso_id'],
				"foto_usuario" => $rs['foto_usuario'],
				"usuario" => $rs['usuario'],
				"empresa" => $rs['empresa'],
				"liberacao" => $rs['liberacao'],
				"data" => $rs['data'],
				"hora" => $rs['hora'],
				"tipo_acao" => $rs['tipo_acao'],
				"tipo_locomocao" => $rs['tipo_locomocao'],
				"documento_pessoa" => $rs['documento_pessoa'],
				"usuario_id" => $rs['usuario_id']
			);		

			$cont++;
		}

		echo json_encode($obj_retorno, JSON_UNESCAPED_UNICODE);

	

?>