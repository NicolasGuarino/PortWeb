<?php
	function conectar(){
		$url 	= $_SERVER['HTTP_HOST'];
		$array 	= ["127.0.0.1", "localhost", "192.168.1.156"];
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		//Se for local, conecta com banco local
		if(in_array($url, $array)){
			$conecta = mysqli_connect('localhost', 'root', '','portaria_db');
		} 	
		//Se for servidor de homologação online, banco de homologação
		else if (strpos($actual_link, 'homologacao') !== false) {
		    $conecta = mysqli_connect('portaria_db_h.mysql.dbaas.com.br', 'portaria_db_h', 'P0rt@ri@','portaria_db_h');

		//Se não, produção
		}else{
			$conecta = mysqli_connect('portaria_db.mysql.dbaas.com.br', 'portaria_db', 'P0rt@ri@','portaria_db');
		}
		
		mysqli_set_charset($conecta,'utf8');

		mysqli_query($conecta, "SET NAMES 'utf8'");
		mysqli_query($conecta, 'SET character_set_connection=utf8');
		mysqli_query($conecta, 'SET character_set_client=utf8');
		mysqli_query($conecta, 'SET character_set_results=utf8');

		return $conecta;		
	}
		

?>