<?php 
     include 'conexao.php';

     header("Content-Type: text/html; charset=UTF-8", true);
     ini_set('default_charset', 'UTF-8');
 
     $conexao = conectar();
 

    $query1 = "select  status from tbl_log_conexao where conexao = 'Servidor' order by log_conexao_id desc limit 1;";
    $query2 = "select  status from tbl_log_conexao where conexao = 'RFID' order by log_conexao_id desc limit 1;";
    $query3 = "select  status from tbl_log_conexao where conexao = 'Arduino' order by log_conexao_id desc limit 1;";
    
    $status_servidor = exec_query($conexao, $query1)[0]['status'];
    $status_rfid = exec_query($conexao, $query2)[0]['status'];
    $status_arduino = exec_query($conexao, $query3)[0]['status'];




    $obj_status[] = array(
        'status_servidor' => $status_servidor,
        'status_rfid' => $status_rfid,
        'status_arduino' => $status_arduino
    );

    echo json_encode($obj_status, JSON_UNESCAPED_UNICODE);

?>