
<?php
	require_once "conexao.php";

	$conexao = conectar();

	if(isset($_POST['nome'])) {
		$nome 	  = addslashes($_POST['nome']);
		$telefone = addslashes($_POST['telefone']);
		$email 	  = addslashes($_POST['email']);
		$imagem   = $_FILES['imagem'];
		$caminho  = "img/";
		$caminho_upload = "../".$caminho.$imagem['name'];
		$caminho_banco = $caminho.$imagem['name'];
	
		if(move_uploaded_file($imagem['tmp_name'], $caminho_upload)) {
			$query  = "insert into empresa(nome, foto, telefone, email)";
			$query .= "values('".$nome."', '".$caminho_banco."', '".$telefone."', '".$email."');";
			$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));

			echo intval($result);
		}else{
			echo "Erro: " . $imagem['error'];
		}
		
	}

	mysqli_close($conexao);
?>