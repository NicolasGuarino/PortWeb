<?php
	include 'conexao.php';

	$conexao = conectar();

	if(isset($_REQUEST['numero_etiqueta'])) {
		$numero_etiqueta = $_REQUEST['numero_etiqueta'];

		if(eCarro($numero_etiqueta)) {
			$query  = "select d_u.numero_etiqueta from veiculo as v ";
			$query .= "inner join rel_usuario_veiculo as uv on(uv.veiculo_id=v.veiculo_id) ";
			$query .= "inner join usuario as u on (u.usuario_id=uv.usuario_id) ";
			$query .= "inner join documento as d_v on(d_v.documento_id=v.documento_id) ";
			$query .= "inner join documento as d_u on(d_u.documento_id=u.documento_id) ";
			$query .= "where d_v.numero_etiqueta = '".$numero_etiqueta."'; ";
		}else{
			$query  = "select d_v.numero_etiqueta from veiculo as v ";
			$query .= "inner join rel_usuario_veiculo as uv on(uv.veiculo_id=v.veiculo_id) ";
			$query .= "inner join usuario as u on (u.usuario_id=uv.usuario_id) ";
			$query .= "inner join documento as d_v on(d_v.documento_id=v.documento_id) ";
			$query .= "inner join documento as d_u on(d_u.documento_id=u.documento_id) ";
			$query .= "where d_u.numero_etiqueta = '".$numero_etiqueta."'; ";
		}

		$select = mysqli_query($conexao, $query);
		
		if(mysqli_num_rows($select) == 0){
			$retorno = array('numero_etiqueta' => 'null');
		}else{
			$rs = mysqli_fetch_array($select);
			$retorno = array('numero_etiqueta' => $rs['numero_etiqueta']);
		}

		echo json_encode($retorno);
		mysqli_close($conexao);
	}
	

	function eCarro($num_etiqueta){
		switch (strtoupper($num_etiqueta[0])) {
			case 'A': // AUTOMOVEL
				return 1;
				break;
			
			case 'C': // CONDOMINO
				return 0;
				break;
		}
	}

	mysqli_close($conexao);
?>