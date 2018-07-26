<?php
	require_once "conexao.php";

	date_default_timezone_set('America/Araguaina');
	$conexao = conectar();

	$i = $_REQUEST['numero_inicial'];
	$numero_final = $_REQUEST['numero_final'];
	$prefixo = $_REQUEST['prefixo'];

	$query  = "select * from documento order by documento_id desc limit 1;";
	$select = mysqli_query($conexao, $query);
	$rs = mysqli_fetch_array($select);

	$ultimo_documento_id = $rs['documento_id'] + 1;
	while ($i <= $numero_final){
		$hora = date("Y-m-d H:m:s");
		
		$query   = "insert into documento (documento_id, numero_etiqueta, tipo_etiqueta, numero_documento, empresa_id, ultima_atualizacao, disponibilidade) ";
		$query  .= "values(".$ultimo_documento_id.",'".$prefixo.sprintf("%023s", $i)."' , 'RFID', '".$i."', 1, '".$hora."', '1');";
		$result  = mysqli_query($conexao, $query) or die("Erro: " . mysqli_error($conexao));

		$query  = "insert into rel_status_documento(status_documento_id, documento_id, hora) ";
		$query .= "values(1, ".$ultimo_documento_id.", '".$hora."');";
		$result  = mysqli_query($conexao, $query) or die("Erro: " . mysqli_error($conexao));
		
		$i++;
		$ultimo_documento_id++;
	}

	echo intval($result);

	mysqli_close($conexao);
?>