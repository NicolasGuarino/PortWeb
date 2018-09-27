<?php 
	require_once "conexao.php";

	$con = conectar();

	$campo = $_REQUEST['campo'];
	$valor = $_REQUEST['valor'];


	$resultado = [];

	$campo = strtolower($campo);

	switch ($campo) {
		case 'rg':
			$query = "select rg from usuario where rg = '".$valor."' and ativo = 1;";
			break;
		case 'cpf':
			$query = "select cpf from usuario where cpf = '".$valor."' and ativo = 1;";
			break;
		case 'placa':
			$query = "select placa from veiculo where placa = '".$valor."' and ativo = 1;";
			break;
		default:
			$resultado = array('resultado' => 0, 'mensagem' => 'Parametros incorretos');
			break;
	}

	$result = mysqli_query($con, $query);

	if(mysqli_num_rows($result) > 0) $resultado = array('resultado' => 1, 'mensagem' => 'Valor já existente no banco');
	else $resultado = array('resultado' => 0, 'mensagem' => 'Valor não encontrado no banco');

	echo json_encode($resultado);
?>