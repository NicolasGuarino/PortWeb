<?php
    session_start();
    require_once "conexao.php";

    $con = conectar();

    $token = $_GET['token'];
    
    $query = "update usuario set token_web = '".$token."' where usuario_id=".$_SESSION['usuario']['usuario_id'].";";
    $res   = mysqli_query($con, $query) or die(
        mysqli_error($con)
    );

    echo intval($res);
?>