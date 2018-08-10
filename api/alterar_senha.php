<?php  
	include("conexao.php");

	$con = conectar();

	$senha = addslashes($_REQUEST['senha']);
	$usuario_id = addslashes($_REQUEST['usuario_id']);

	$query  = "update usuario set senha =SHA1('".$senha."') where usuario_id = ".$usuario_id.";";
	$select = mysqli_query($con, $query) or die(mysqli_error($con));

	if(intval($select)) {
		$retorno = array('valor' => true, 'mensagem' => "Senha alterada com sucesso");		
	}

	echo json_encode($retorno);
?>
