<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
    ini_set('default_charset', 'UTF-8');
    
    $conexao = conectar();

    if(isset($_REQUEST['usuario_id'])){
        $usuario_id = $_REQUEST['usuario_id'];

        $query = "select ra.tipo_acao from usuario as u inner join rel_registro_usuario as ru on(ru.usuario_id=u.usuario_id) 
                    inner join registro_acesso as ra on(ra.registro_acesso_id=ru.registro_acesso_id) 
                    where u.usuario_id = $usuario_id order by ru.registro_acesso_id desc limit 1;";

    }else {
        $placa_veiculo = $_REQUEST['placa'];

        $query = "select ra.tipo_acao from veiculo as v inner join registro_acesso as ra on ra.veiculo_id = v.veiculo_id 
                where placa = '$placa_veiculo' order by registro_acesso_id desc limit 1;";
    }

    $select_tipo_acao = mysqli_query($conexao, $query);
    $rs = mysqli_fetch_array($select_tipo_acao);

    $tipo_acao = ($rs['tipo_acao'] == "ENTRADA") ? "SAIDA" : "ENTRADA";

    $array = array(
        "tipo_acao" => $tipo_acao
    );

    echo json_encode($array);