<?php
	require_once "conexao.php";

	$conexao = conectar();

	$veiculo_id	  = $_REQUEST['veiculo_id'];
	$placa 	 	  = $_REQUEST['placa'];
	$modelo 	  = $_REQUEST['modelo'];
	$marca 	 	  = $_REQUEST['marca'];
	$cor 	 	  = $_REQUEST['cor'];
	@$foto  	  = $_FILES['foto'];
	$atualizarImg = $_REQUEST['atualizarImg'];


	if($atualizarImg == "true") {
		$caminho = "img/";
		$caminho_upload = "../".$caminho.$foto['name'];
		$caminho_banco  = $caminho.$foto['name'];

		if(move_uploaded_file($foto['tmp_name'], $caminho_upload)) $result = "Upload OK";
		else $result = "Erro upload: " . $foto['error'];
	}else{
		$caminho_banco = $atualizarImg;
	}

	$query  = "update veiculo set placa='".$placa."', modelo='".$modelo."', marca='".$marca."', cor='".$cor."', foto='".$caminho_banco."' where veiculo_id = ".$veiculo_id.";";
	$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));
	
	echo intval($result);

	mysqli_close($conexao);
?>