<?php
	require_once "conexao.php";

	date_default_timezone_set('America/Araguaina');
	$conexao = conectar();

	$qtde = $_REQUEST['qtde'];
	$prefixo = $_REQUEST['prefixo'];

	$query  = "select * from documento where substring(numero_etiqueta, 1, 1) = '".$prefixo."' order by numero_etiqueta desc limit 1;";
	$select = mysqli_query($conexao, $query);
	$rs = mysqli_fetch_array($select);

	$numero_etiqueta = substr($rs['numero_etiqueta'], 1) + 1;

	$query  = "select * from documento order by documento_id desc limit 1;";
	$select = mysqli_query($conexao, $query);
	$rs = mysqli_fetch_array($select);
	$ultimo_documento_id = $rs['documento_id'] + 1;

	$i = 0;
	$query_documento  	   = "insert into documento (documento_id, numero_etiqueta, tipo_etiqueta, empresa_id, ultima_atualizacao, disponibilidade) values";
	$query_relacionamento  = "insert into rel_status_documento(status_documento_id, documento_id, hora) values";

	while ($i < $qtde){
		$hora = date("Y-m-d H:m:s");
		
		$query_documento  .= "(".$ultimo_documento_id.", '".$prefixo.sprintf("%023s", $numero_etiqueta)."', 'RFID', 1, '".$hora."', '1'), ";


		$query_relacionamento .= "(1, ".$ultimo_documento_id.", '".$hora."'), ";
		
		$i++;
		$numero_etiqueta++;
		$ultimo_documento_id++;
	}

	$query_documento = substr_replace($query_documento, ";", strlen($query_documento)-2);
	$query_relacionamento = substr_replace($query_relacionamento, ";", strlen($query_relacionamento)-2);
	
	$result  = mysqli_query($conexao, $query_documento) or die("Erro: " . mysqli_error($conexao));
	$result  = mysqli_query($conexao, $query_relacionamento) or die("Erro: " . mysqli_error($conexao));

	echo intval($result);
	mysqli_close($conexao);
?>