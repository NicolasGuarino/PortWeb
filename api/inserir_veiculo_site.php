<?php
	require_once "conexao.php";

	$conexao = conectar();

	$documento 	 = $_REQUEST['documento'];
	$usuario 	 = $_REQUEST['usuario'];
	$placa 	 	 = $_REQUEST['placa'];
	$modelo 	 = $_REQUEST['modelo'];
	$marca 	 	 = $_REQUEST['marca'];
	$cor 	 	 = $_REQUEST['cor'];
	$foto  	 	 = $_FILES['foto'];
	$caminho 	 = "img/";
	
	$caminho_upload = "../".$caminho.$foto['name'];
	$caminho_banco = $caminho.$foto['name'];
	
	if(move_uploaded_file($foto['tmp_name'], $caminho_upload)) {
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

			echo intval($result);
		}
	}else{
		echo "Erro: " . $foto['error'];
	}
	
	mysqli_close($conexao);
?>