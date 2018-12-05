<?php 
    include 'conexao.php';

    header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

    $conexao = conectar();
    $placa = $_REQUEST['placa_veiculo'];
    $usuario_id = $_REQUEST['usuario_id'];
    $empresa_destino_id = $_REQUEST['empresa_destino_id'];

    if($_REQUEST['placa_veiculo_id'] == "0"){
        //Registra o novo veículo e registra a entrada
        if($_REQUEST['placa_veiculo'] != ""){
            $query_document = "select * from documento where numero_etiqueta like 'A%' and disponibilidade = 1 order by documento_id asc  limit 1; ";
            $documento_id_novo = exec_query($conexao, $query_document)[0]['documento_id'];
            
            echo $query_document;

            $query_insert = "INSERT INTO veiculo (documento_id, placa, foto, ativo) VALUES ('$documento_id_novo', '$placa', 'img/icones/ic_carro.png', '1');";
            
            mysqli_query($conexao, $query_insert);
            $veiculo_id = mysqli_insert_id($conexao);
            

            $query_update = "update documento set disponibilidade = 0 where documento_id = $documento_id_novo;";
            mysqli_query($conexao, $query_update);

            $query_sync_car_user = "INSERT INTO rel_usuario_veiculo (veiculo_id, usuario_id) VALUES ('$veiculo_id', '$usuario_id');";
            mysqli_query($conexao, $query_sync_car_user);
            
            
            $query_get_document = "select * from veiculo where veiculo_id = $veiculo_id;";
            $documento_id = exec_query($conexao, $query_get_document)[0]['documento_id'];
        
        
        }else{
            $query_get_document = "select * from usuario where usuario_id = $usuario_id;";
            $documento_id = exec_query($conexao, $query_get_document)[0]['documento_id'];
        }

    }else{
        $query_veicle = "select * from veiculo where placa = '$placa'";
        $documento_id = exec_query($conexao, $query_veicle)[0]['documento_id'];
    }

    // $query_visitante_empresa = "update usuario set empresa_destino_id = $empresa_destino_id where usuario_id = $usuario_id ;";
    // mysqli_query($conexao, $query_visitante_empresa);

    
    $return = array(
        'documento_id' => $documento_id
    );

    echo json_encode($return, JSON_UNESCAPED_UNICODE);