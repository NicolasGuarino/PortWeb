<?php
	function conectar(){
		$url 	= $_SERVER['HTTP_HOST'];
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		//Se for servidor de homologação online, banco de homologação
		if (strpos($actual_link, 'homologacao') !== false || strpos($actual_link, 'localhost') !== false || strpos($actual_link, '192.168') !== false) {
            $conecta = mysqli_connect('portaria_db_h.mysql.dbaas.com.br', 'portaria_db_h', 'Port@r1@_Pr1m1','portaria_db_h');
            // $conecta = mysqli_connect('192.168.1.44', 'root', '','portaria_db');

		//Se não, produção
		}else{
            // echo "REAl";
			$conecta = mysqli_connect('portaria_db.mysql.dbaas.com.br', 'portaria_db', 'Port@r1@_Pr1m1','portaria_db');
		}
		
        mysqli_set_charset($conecta,'utf8');
        
        mysqli_query($conecta, "SET NAMES 'utf8'");
        mysqli_query($conecta, 'SET character_set_connection=utf8');
        mysqli_query($conecta, 'SET character_set_client=utf8');
        mysqli_query($conecta, 'SET character_set_results=utf8');

       return $conecta;                             
    }

    function exec_query($con, $query){
      $exec = mysqli_query($con, $query);
      $res = null;

      if(!is_bool($exec)) while($rs = mysqli_fetch_array($exec)) $res[] = $rs;  
      else $res = $exec;

      return $res;
    }
                   

?>
