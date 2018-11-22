<?php

		include 'conexao.php';

		header("Content-Type: text/html; charset=UTF-8", true);
		ini_set('default_charset', 'UTF-8');

		$conexao = conectar();
		
		$obj_retorno = [];
		$limite = (isset($_REQUEST['limite'])) ? $_REQUEST['limite'] : 10;
		$pagina = (isset($_REQUEST['pagina'])) ? $_REQUEST['pagina'] : 1;
		$where = "";

		if(isset($_GET['filtro'])){
			$filtro = $_GET['filtro'];
			$where = " and (u.nome like '%".$filtro."%' or date_format(ra.hora, '%d/%m/%y') like '%".$filtro."%') ";
		}

		if (isset($_GET['filtro_data'])) {
			date_default_timezone_set('America/Sao_Paulo');
			$data_hoje = date('d/m/y');
			$semana_passada = date('Y/m/d', strtotime('-7 days'));;

			if ($_GET['filtro_data'] == "hoje") {
				$where = " and date_format(ra.hora, '%d/%m/%y') like '%".$data_hoje."%' ";

			}else {
				$where = " and ra.hora> '".$semana_passada."' ";
			}

		}

		if(isset($_REQUEST['empresa_id'])) {
			$empresa_id = $_REQUEST['empresa_id'];
			$where .= " and e.empresa_id = ". $empresa_id. " ";
		}

		$query = "select 
						u.usuario_id,
						ra.registro_acesso_id,
						v.foto AS foto_carro,
						CONCAT(v.marca, ' ', v.modelo, ',', v.cor) AS carro,
						v.placa,
						u.foto AS foto_usuario,
						u.nome AS usuario,
						e.nome AS empresa,
						ra.liberacao,
						DATE_FORMAT(ra.hora, '%d/%m/%y') AS data,
						DATE_FORMAT(ra.hora, '%H:%i:%s') AS hora,
						ra.tipo_acao,
						ra.tipo_locomocao,
						u.documento_id AS documento_pessoa,
						u.usuario_id from registro_acesso as ra 
					left join rel_registro_usuario as ru on(ru.registro_acesso_id=ra.registro_acesso_id)
					left join usuario as u on(u.usuario_id=ru.usuario_id)
					left join rel_empresa_funcionario as ef on ef.usuario_id = u.usuario_id
					left join empresa as e on e.empresa_id = ef.empresa_id
					left join rel_usuario_veiculo as uv on(uv.usuario_id=u.usuario_id)
					left join veiculo as v on(v.veiculo_id=uv.veiculo_id) where u.tipo_usuario_id in (1,4) ".$where."
					group by ra.registro_acesso_id order by ra.hora desc limit ".$limite." offset ".($pagina * $limite - $limite).";";
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