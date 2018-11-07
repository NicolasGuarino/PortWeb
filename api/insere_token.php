<?php
	include "conexao.php";

	$usuario_id = $_GET['usuario_id'];
	$token 		= $_GET['token_firebase'];

	// Conexão com o banco de dados
	$conexao = conectar();

	// Atualizando o 'token' do usuário
	$query  = "update usuario set token_firebase = '". $token ."' ";
	$query .= "where usuario_id = ". $usuario_id .";";

	// Executando a query
	$exec = mysqli_query($conexao, $query);

	echo $exec;
?>