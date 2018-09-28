<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();
	
	$query  = "select ra.liberacao, ra.acionamento_id, u.nome, u.email, u.foto as 'foto_usuario', CONCAT(v.modelo, ' - ', v.marca) as carro, v.placa, v.foto as 'foto_veiculo' from registro_acesso as ra ";
	$query .= "inner join rel_registro_usuario as ru on(ru.registro_acesso_id=ra.registro_acesso_id) ";
	$query .= "inner join usuario as u on(u.usuario_id=ru.usuario_id)  ";
	$query .= "left join rel_usuario_veiculo as uv on(uv.usuario_id=u.usuario_id) ";
	$query .= "left join veiculo as v on(v.veiculo_id=uv.veiculo_id) ";
	$query .= "where date_format(ra.hora, '%Y-%d-%m %H:%i:%s') between date_format(date_sub(now(), INTERVAL 0.5 SECOND),'%Y-%d-%m %H:%i:%s') and date_format(now(), '%Y-%d-%m %H:%i:%s')";
	$query .= "order by ra.registro_acesso_id desc limit 1;";

	$select = mysqli_query($conexao, $query);

    $obj_final = [];
    $usuario = [];
    $veiculo = [];
	// echo $query."<br/>";
    while($rs = mysqli_fetch_array($select)) {
        $usuario = array("lbl_principal" => $rs['nome'], "lbl_secundaria" => $rs['email'], "caminho_img" => $rs['foto_usuario']);
        $veiculo = array("lbl_principal" => $rs['carro'], "lbl_secundaria" => $rs['placa'], "caminho_img" => $rs['foto_veiculo']);

        $obj_final = array("usuario" => $usuario, "veiculo" => $veiculo, "tipo_leitura" => $rs['acionamento_id'], "liberado" => $rs['liberacao']);
    }
	
	echo json_encode($obj_final);
?>