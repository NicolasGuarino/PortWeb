<?php 
	
	require_once "conexao.php";

	$con = conectar();

	$query = "select * from usuarios;";
	$exec  = mysqli_query($con, $query) 
		or die(json_encode(['codigo_erro' => '0', 'erro' => 'Erro na busca dos dados', 'detalhes' =>mysqli_error($con)]));

	while ($rs = mysqli_fetch_array($exec)) {
		echo $rs['nome']."<br/>";
	}
?>		
