<?php
    function conectar(){
        include "../../../conexao_db.php";
        return conectar_db("portaria");
    }

    function exec_query($con, $query){
      $exec = mysqli_query($con, $query);
      $res = null;

      if(!is_bool($exec)) while($rs = mysqli_fetch_array($exec)) $res[] = $rs;  
      else $res = $exec;

      return $res;
    }