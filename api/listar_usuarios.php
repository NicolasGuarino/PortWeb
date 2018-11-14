<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();

	$obj_retorno = [];
	$where = "";
	if(isset($_GET['filtro'])){
		$filtro = $_GET['filtro'];
		$where = " and (u.nome like '%".$filtro."%' or u.cpf like '%".$filtro."%' or u.rg like '%".$filtro."%' or date_format(u.ultima_atualizacao, '%d/%m/%y') like '%".$filtro."%') ";
	}

	if (isset($_GET['filtro_funcionario'])) {

		if ($_GET['filtro_funcionario'] == "funcionario") {
			$where = " and u.tipo_usuario_id = 1 ";

		}else {
			$where = " and u.tipo_usuario_id = 4 ";
		}

	}

	if (isset($_GET['tipo_usuario_id'])) {
		$tipo_usuario_id = $_GET['tipo_usuario_id'];
		if($tipo_usuario_id == 0) $where = "";
		else $where = " and tipo_usuario_id = ".$tipo_usuario_id;
	}


	$query = "select u.* from usuario as u left join documento as d on(d.documento_id=u.documento_id) where u.ativo = 1 and u.tipo_usuario_id in (1,4,8) ".$where." order by nome asc";

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