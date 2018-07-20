<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();

	$query  = "select ra.registro_acesso_id, u.usuario_id, v.veiculo_id, u.foto as 'foto_usuario', u.nome, u.documento_id, CONCAT(v.modelo, ' - ', v.marca) as carro, v.placa, v.foto as 'foto_veiculo' from registro_acesso as ra ";
	$query .= "inner join rel_registro_usuario as ru on(ru.registro_acesso_id=ra.registro_acesso_id) ";
	$query .= "inner join usuario as u on(u.usuario_id=ru.usuario_id) ";
	$query .= "inner join rel_usuario_veiculo as rv on(rv.usuario_id=u.usuario_id) ";
	$query .= "inner join veiculo as v on(rv.veiculo_id=v.veiculo_id) ";
	$query .= "where date_format(ra.hora, '%Y-%d-%m %H:%i:%s') between date_format(date_sub(now(), INTERVAL 500000 MICROSECOND),'%Y-%d-%m %H:%i:%s') and date_format(now(), '%Y-%d-%m %H:%i:%s')";
	$query .= "order by ra.registro_acesso_id desc limit 1;";

	$select = mysqli_query($conexao, $query);

	$rs = mysqli_fetch_array($select);
	
	echo json_encode($rs);
?>