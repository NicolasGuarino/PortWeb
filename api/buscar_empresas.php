<?php 

    include 'conexao.php';

    header("Content-Type: text/html; charset=UTF-8", true);
    ini_set('default_charset', 'UTF-8');

    $conexao = conectar();

    if(isset($_REQUEST['filtro'])){
        $filtro = $_REQUEST['filtro'];
    
        $query = "select * from empresa where nome like '%$filtro%';";


        $select = mysqli_query($conexao, $query);


        while($rs = mysqli_fetch_array($select)){
            $obj_empresas[] = array(
                'id' => $rs['empresa_id'],
                'nome' => $rs['nome']
            );
        }

        echo json_encode($obj_empresas, JSON_UNESCAPED_UNICODE);
    }


    


