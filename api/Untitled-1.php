<?php
    date_default_timezone_set('America/Sao_Paulo');
    $dtObj = date_create(date('Y-m-d H:i:s'));

    echo $dtObj->format('Y-m-d H:i:s')."<br/>";

    require_once "conexao.php";

    $conexao = conectar();

    $query = "select now();";
    $res   = mysqli_query($conexao, $query);

    echo json_encode( mysqli_fetch_array($res)[0]);
?>