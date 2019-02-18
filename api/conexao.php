<?php
    function conectar(){
      $pasta_a_voltar = "";

      // Coleta a pasta atual
      $pieces = explode("/", $_SERVER['PHP_SELF']);
      
      $loop = count($pieces) - 2;

      // Loop até a pasta raiz
      for ($i=0; $i<$loop; $i++) {
          $pasta_a_voltar .= "../";
      }

      require_once $pasta_a_voltar."../conexao_db.php";
      
      return conectar_db("portaria");
    }

    function exec_query($con, $query){
      $exec = mysqli_query($con, $query);
      $res = null;

      if(!is_bool($exec)) while($rs = mysqli_fetch_array($exec)) $res[] = $rs;  
      else $res = $exec;

      return $res;
    }
?>