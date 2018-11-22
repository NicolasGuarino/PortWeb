<?php
	require_once "conexao.php";
	date_default_timezone_set('America/Araguaina');
	$conexao = conectar();

	$usuario 	 = $_REQUEST['usuario'];
	$placa 	 	 = $_REQUEST['placa'];
	$modelo 	 = $_REQUEST['modelo'];
	$marca 	 	 = $_REQUEST['marca'];
	$cor 	 	 = $_REQUEST['cor'];
	@$foto  	 	 = $_FILES['foto'];
	$caminho 	 = "img/";
	
	if($foto != NULL) {
		$caminho_upload = "../".$caminho.$foto['name'];
		$caminho_banco = $caminho.$foto['name'];
	}else{
		$caminho_banco = "img/icones/ic_carro.png";
	}

	$hora = date('Y-m-d H:i:s');
	
	@$upload_ok = move_uploaded_file($foto['tmp_name'], $caminho_upload);

	if($upload_ok || $foto == NULL) {
		$query = "select * from documento where substring(numero_etiqueta, 1,1) = 'A' and disponibilidade = 1 order by documento_id asc limit 1;";
		$result = mysqli_query($conexao, $query);
		$documento = mysqli_fetch_array($result)['documento_id'];

		$query  = "insert into veiculo(documento_id, placa, modelo, marca, cor, foto)";
		$query .= "values('".$documento."', '".$placa."', '".$modelo."', '".$marca."', '".$cor."', '".$caminho_banco."');";
		$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));

		if(intval($result) == 1) {
			$query  = "select veiculo_id from veiculo order by veiculo_id desc limit 1;";
			$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));
			$rs = mysqli_fetch_array($result);

			$rs['veiculo_id'];

			$query  = "insert into rel_usuario_veiculo(usuario_id, veiculo_id)";
			$query .= "values('".$usuario."', '".$rs['veiculo_id']."');";
			$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));			

			$query = "update documento set disponibilidade = 0, ultima_atualizacao = '".$hora."' where documento_id =". $documento;
			$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));

			$query = "insert into rel_status_documento (status_documento_id, documento_id, hora) values (1, ".$documento.", '".$hora."');";
			$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));

			echo intval($result);
		}
	}else{
		echo "Erro: " . $foto['error'];
	}
	
	mysqli_close($conexao);
?>