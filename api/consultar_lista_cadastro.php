<?php
	include "conexao.php";

	$conexao 		= conectar();
	$lista_registro = [];

	// Consultando a lista de cadastro
	$query  = "select d.numero_etiqueta, sd.status_documento_id, u.usuario_id, u.nome as nome_usuario, u.foto,  u.email, u.documento_id as 'documento_pessoa', v.documento_id as documento_veiculo, e.nome as empresa, sd.nome status_documento from usuario as u ";
	$query .= "inner join rel_usuario_veiculo as uv on(uv.usuario_id = u.usuario_id) ";
	$query .= "inner join veiculo as v on(uv.veiculo_id = v.veiculo_id) ";
	$query .= "inner join documento as d on(d.documento_id = u.documento_id) ";
	$query .= "inner join rel_empresa_funcionario as ef on(ef.usuario_id = u.usuario_id) ";
	$query .= "inner join empresa as e on(ef.empresa_id = e.empresa_id) ";
	$query .= "inner join rel_status_documento as rsd on(rsd.documento_id = d.documento_id and d.ultima_atualizacao = rsd.hora) ";
	$query .= "inner join status_documento sd on(rsd.status_documento_id = sd.status_documento_id) ";
	$query .= "group by u.usuario_id order by usuario_id desc;";

	$exec = mysqli_query($conexao, $query);

	// Add os registro a lista
	while($rs = mysqli_fetch_array($exec)) $lista_registro[] = $rs;

	// Imprimindo o resultado em json
	echo json_encode($lista_registro);
?>