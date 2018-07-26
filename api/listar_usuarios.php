<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();

	$where = "";
	if(isset($_GET['filtro'])){
		$filtro = $_GET['filtro'];
		$where = " where (u.nome like '%".$filtro."%' or date_format(u.ultima_atualizacao, '%d/%m/%y') like '%".$filtro."%') ";
	}

	if (isset($_GET['filtro_data'])) {
		date_default_timezone_set('America/Sao_Paulo');
		$data_hoje = date('d/m/y');
		$semana_passada = date('Y/m/d', strtotime('-7 days'));;

		if ($_GET['filtro_data'] == "hoje") {
			$where = " where date_format(u.ultima_atualizacao, '%d/%m/%y') like '%".$data_hoje."%' ";

		}else {
			$where = " where u.ultima_atualizacao > '".$semana_passada."' ";
		}

	}

	if (isset($_GET['tipo_usuario_id'])) {
		$tipo_usuario_id = $_GET['tipo_usuario_id'];
		$where = " where tipo_usuario_id = ".$tipo_usuario_id;
	}


	$query = "select u.* from usuario as u inner join documento as d on(d.documento_id=u.documento_id) ".$where." order by usuario_id desc";

			//inner join rel_empresa_funcionario as ef on(ef.usuario_id=u.usuario_id) 
			//inner join empresa as e on(e.empresa_id=ef.empresa_id) 
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