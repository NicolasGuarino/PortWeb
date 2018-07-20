<?php
	require_once "conexao.php";

	$conexao = conectar();
	$lst_usuarios = [];

	$query = "select * from usuario where tipo_usuario_id = 1 or tipo_usuario_id = 3;";
	$select = mysqli_query($conexao, $query);

	while($rs = mysqli_fetch_array($select)) {
		$usuario = array
		(
			"usuario_id" => $rs['usuario_id'],
			"nome" => $rs['nome'],
			"cpf" => $rs['cpf'],
			"email" => $rs['email'],
		);

		$lst_usuarios[] = $usuario;
	}

	echo json_encode($lst_usuarios);
	mysqli_close($conexao);
?>