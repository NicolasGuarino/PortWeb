<?php
    session_start();
    require_once "conexao.php";

    $con = conectar();

    $token = $_GET['token'];
    
    $query = "update tbl_usuario set token_web = '".$token."' where usuario_id=".$_SESSION['usuario_id']['usuario_id'].";";
    $res   = mysqli_query($con, $query) or die(
        mysqli_error($con)
    );

    echo intval($res);
?>