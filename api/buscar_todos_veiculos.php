<?php 

    include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();

	if(isset($_REQUEST['usuario_id'])){
        $usuario_id = $_REQUEST['usuario_id'];

        $query = "select * from veiculo as v
            left join rel_usuario_veiculo as uv on uv.veiculo_id = v.veiculo_id
            left join usuario as u on u.usuario_id = uv.usuario_id 
            where u.usuario_id = $usuario_id ;";


        $select = mysqli_query($conexao, $query);


        while($rs = mysqli_fetch_array($select)){
            $obj_carros[] = array(
                'id' => $rs['veiculo_id'],
                'placa' => $rs['placa']
            );
        }

        $obj_carros[] = array(
            'id' => 0,
            'placa' => 'Outro'
        );
    }

    echo json_encode($obj_carros, JSON_UNESCAPED_UNICODE);
