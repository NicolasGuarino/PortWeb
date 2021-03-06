<?php

		include 'conexao.php';

		header("Content-Type: text/html; charset=UTF-8", true);
		ini_set('default_charset', 'UTF-8');

		$conexao = conectar();
		
		$limite = (isset($_REQUEST['limite'])) ? $_REQUEST['limite'] : 10;
		$pagina = (isset($_REQUEST['pagina'])) ? $_REQUEST['pagina'] : 1;
		$where = "";
		$tipo_usuario = (isset($_REQUEST['tipo_usuario'])) ? $_REQUEST['tipo_usuario'] : "1,3,4";
		$order = "ra.hora desc";

		// Ordem alfabética ou de data
		if(isset($_GET['ordem']) && $_GET['ordem'] != null){

			// Valor da ordem
			$ordem = $_GET['ordem'];

			// Definindo a irdem (alfabética ou por data)
			if($ordem == "az" || $ordem == "za"){
				$ordem = ($ordem == "az")? "asc" : "desc";
				$order = "u.nome ". $ordem .", ra.hora desc ";

			}elseif($ordem == "09" || $ordem == "90"){
				$ordem = ($ordem == "09")? "asc" : "desc";
				$order = "ra.hora ". $ordem ." ";
			}
		}

		// FILTROS
		if(isset($_GET['filtro'])){
			$filtro = strtolower($_GET['filtro']);

			// Verificando se não há parâmetro de ordem
			if(!isset($_GET['ordem']) || $_GET['ordem'] == null)
				$order = "position('". $filtro ."' IN u.nome) asc, ra.hora desc ";

			$where = " and (lower(u.nome) like '%".$filtro."%' or lower(v.placa) like '%". $filtro ."%' or lower(v.marca) like '%". $filtro ."%'  or date_format(ra.hora, '%d/%m/%y') like '%".$filtro."%') ";

			if(isset($_GET['data_inicio']) && isset($_GET['data_termino']) && $_GET['data_termino'] != null && $_GET['data_inicio'] != null){
				$data_inicio  = $_GET['data_inicio'];
				$data_termino = $_GET['data_termino'];

				$where .= " and date_format(ra.hora, '%y-%m-%d') between date_format('" . $data_inicio . "', '%y-%m-%d') and date_format('" . $data_termino . "', '%y-%m-%d') ";
			}
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

		if(isset($_REQUEST['empresa_id']) && $_REQUEST['empresa_id'] != null) {
			$empresa_id = $_REQUEST['empresa_id'];
			$where .= " and (e.empresa_id = ". $empresa_id . " or ra.empresa_destino_id = ". $empresa_id .") ";
		}

		$query = "select 
					u.usuario_id,
					tp.nome as tipo_usuario,
					ra.registro_acesso_id,
					v.foto AS foto_carro,
					CONCAT(v.marca, ' ', v.modelo, ',', v.cor) AS carro,
					v.placa,
					v.marca,
					v.modelo,
					u.foto AS foto_usuario,
					u.nome AS usuario,
					e.nome AS empresa,
					e.email as email_empresa,
					e.telefone as telefone_empresa,
					ra.liberacao,
					DATE_FORMAT(ra.hora, '%d/%m/%y') AS data,
					DATE_FORMAT(ra.hora, '%H:%i:%s') AS hora,
					DATE_FORMAT(ra.hora, '%H:%i - %d/%m') AS data_hora,
					ra.tipo_acao,
					ra.tipo_locomocao,
					u.documento_id AS documento_pessoa,
					u.usuario_id from registro_acesso as ra 
				left join rel_registro_usuario as ru on(ru.registro_acesso_id=ra.registro_acesso_id)
				left join usuario as u on(u.usuario_id=ru.usuario_id)
				left join tipo_usuario as tp on (u.tipo_usuario_id = tp.tipo_usuario_id)
				left join rel_empresa_funcionario as ef on ef.usuario_id = u.usuario_id
				left join empresa as e on (e.empresa_id = ef.empresa_id or e.empresa_id = ra.empresa_destino_id)
				left join veiculo as v on(v.veiculo_id=ra.veiculo_id)
				where u.tipo_usuario_id in (".$tipo_usuario.") ".$where." group by ra.registro_acesso_id order by " . $order . " ";


		// Complemento da query
		$query_comp = "limit ".$limite." offset ".($pagina * $limite - $limite).";";

		// echo $query;
		// echo "<br />";
		// echo "<br />";

		// Trazendo a quantidade de registros sem a condição
		$exec = mysqli_query($conexao, $query);
		$qtd_registros = mysqli_num_rows($exec);
		$qtd_pagina = ceil($qtd_registros / $limite);

		$select = mysqli_query($conexao, $query . $query_comp);

		$obj_retorno = [];
		while($rs = mysqli_fetch_array($select)){
			$obj_retorno[] = $rs;
		}

		if(isset($_GET['qtd_pagina']))
			echo json_encode(["qtd_pagina" => $qtd_pagina, "lista" => $obj_retorno], JSON_UNESCAPED_UNICODE);
		else
			echo json_encode($obj_retorno, JSON_UNESCAPED_UNICODE);
?>