<?php 
	require_once "conexao.php";

	$conexao = conectar();

	$documento_id = $_POST['usuario_id'];
	$nome_imagem = $_POST['nome_imagem'];
	$imagem = $_POST['imagem'];
	
	$caminho_completo = "img/" . $nome_imagem . ".JPG";


	$decodificarImagem = base64_decode($imagem);
	if(file_put_contents("../img/" . $nome_imagem . ".JPG", $decodificarImagem)){
		$sql = "update usuario set foto = '".$caminho_completo."' where usuario_id = '".$documento_id."'";

		$select = mysqli_query($conexao,$sql);

		/*if($select){
			$return "OK";
		}else{
			$return $sql;
		}

		echo($return);*/

		mysqli_close($conexao);

	}
?>