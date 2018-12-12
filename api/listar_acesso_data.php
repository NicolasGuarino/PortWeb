<?php
	include 'conexao.php';

	$conexao = conectar();

	$query = "
	select 
		ra.registro_acesso_id,
	    ra.hora,
	    DATE_FORMAT(ra.hora, '%d/%m/%y') AS data,
	    DATE_FORMAT(ra.hora, '%H:%i:%s') AS hora
	from registro_acesso as ra
	left join rel_registro_usuario as ru on(ru.registro_acesso_id=ra.registro_acesso_id)
	left join usuario as u on(u.usuario_id=ru.usuario_id)
	left join tipo_usuario as tp on (u.tipo_usuario_id = tp.tipo_usuario_id)
	left join rel_empresa_funcionario as ef on ef.usuario_id = u.usuario_id
	left join empresa as e on (e.empresa_id = ef.empresa_id or e.empresa_id = ra.empresa_destino_id)
	left join rel_usuario_veiculo as uv on(uv.usuario_id=u.usuario_id)
	left join veiculo as v on(v.veiculo_id=uv.veiculo_id)
	group by ra.hora;";

	$exec = mysqli_query($conexao, $query);
	$lista_data = [];

	// Preenchendo a lista de datas
	while($data = mysqli_fetch_array($exec)) $lista_data[] = $data;

	// Resultado
	echo json_encode($lista_data);
?>