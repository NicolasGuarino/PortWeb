<?php  
	include 'conexao.php';


	$conexao = conectar();

	$cpf = $_REQUEST['cpf'];

	$query  = "select u.usuario_id, u.nome, u.foto as 'foto', u.cpf, u.rg, u.email, DATE_FORMAT(u.data_nascimento, '%d/%m/%Y') as 'data_nascimento_f', ";
	$query .= "u.data_nascimento, u.telefone, d.numero_etiqueta, d.documento_id, u.tipo_usuario_id, s.nome as 'status', s.status_id ";
	$query .= "from usuario as u inner join documento as d on(d.documento_id=u.documento_id) ";
	$query .= "inner join rel_status_usuario as su on(su.usuario_id=u.usuario_id) ";
	$query .= "inner join status as s on(s.status_id=su.status_id) ";
	$query .= "where cpf = '".$cpf."' and u.ativo = 1 and su.hora = u.ultima_atualizacao order by u.usuario_id desc limit 1;";
	
	$select = mysqli_query($conexao, $query);

	$lista = [];
	$lista_escala[] = [];
	$lista_veiculo[] = [];
	
	while($rs = mysqli_fetch_array($select)) {
		$query_veiculo   = "select * from rel_usuario_veiculo as uv inner join veiculo as v on(v.veiculo_id=uv.veiculo_id) ";
		$query_veiculo  .= "inner join documento as d on(d.documento_id=v.documento_id) where uv.usuario_id = '".$rs['usuario_id']."' and v.ativo = 1;";
	
		$select_veiculos = mysqli_query($conexao, $query_veiculo);

		while($rs_veiculo = mysqli_fetch_array($select_veiculos)) {
			$lista_veiculo[] = $rs_veiculo;
		}

		$query_escala   = "select e.escala_id, e.dia_da_semana, CONCAT(TIME_FORMAT(e.hora_entrada, '%H:%i'), ' - ', TIME_FORMAT(e.hora_saida, '%H:%i')) as horario from escala as e where e.usuario_id = '".$rs['usuario_id']."'";
		$select_escala = mysqli_query($conexao, $query_escala);

		while($rs_escala = mysqli_fetch_array($select_escala)) {
			$lista_escala[] = $rs_escala;
		}

		$rs['veiculos'] = $lista_veiculo;
		$rs['escala'] = $lista_escala;
		$lista[] = $rs;
	}


	echo json_encode($lista);
?>