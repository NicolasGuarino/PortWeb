<?php

		include 'conexao.php';

		header("Content-Type: text/html; charset=UTF-8", true);
		ini_set('default_charset', 'UTF-8');

		$tipo_etiqueta = $_REQUEST['tipo_etiqueta'];
		$tipo_usuario_responsavel = $_REQUEST['tipo_usuario_responsavel'];

	
		$conexao = conectar();
		
		$query = "select d.documento_id, d.numero_etiqueta, d.tipo_etiqueta, d.numero_documento, d.ultima_atualizacao, d.imagem_oculta, e.nome from documento as d ";
		$query .= "inner join empresa as e on (e.empresa_id = d.empresa_id)";
		$query .= "where d.tipo_etiqueta = '".$tipo_etiqueta."' and disponibilidade = 1 and tipo_usuario_responsavel=".$tipo_usuario_responsavel.";";

		//echo($query);

		$cont = 0;

		$select = mysqli_query($conexao, $query);
			
		while($rs = mysqli_fetch_array($select)){
			$obj_retorno[$cont] = array(
				"documento_id" => $rs['documento_id'],
				"numero_etiqueta" => $rs['numero_etiqueta'],
				"tipo_etiqueta" => utf8_encode($rs['tipo_etiqueta']),
				"numero_documento" => $rs['numero_documento'],
				"empresa" => utf8_encode($rs['nome']),
				"ultima_atualizacao" => $rs['ultima_atualizacao'],
				"imagem_oculta" => utf8_encode($rs['imagem_oculta']),
			);		

			$cont++;
		}

		echo json_encode($obj_retorno, JSON_UNESCAPED_UNICODE);

	

?>