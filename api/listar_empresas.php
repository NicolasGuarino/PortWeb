<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');
	session_start();

	$conexao = conectar();

	$empresa_id = $_REQUEST['empresa_id'];

	$query   = "select e.*, count(ef.empresa_id) as 'qtd_funcionario' from empresa as e left join rel_empresa_funcionario as ef on(ef.empresa_id=e.empresa_id) where e.empresa_id > ".$empresa_id." and e.ativo = 1 group by e.empresa_id;";
	$result	 = mysqli_query($conexao, $query);

	$lista_empresa = [];
	while($rs=mysqli_fetch_array($result)) $lista_empresa[] = $rs;

	echo json_encode($lista_empresa);

?>