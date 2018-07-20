<?php  

	function conectar(){
		// $conecta = mysqli_connect('192.168.0.2', 'portaria_db', 'P0rt@ri@','portaria_db');
		$conecta = mysqli_connect('portaria_db.mysql.dbaas.com.br', 'portaria_db', 'P0rt@ri@','portaria_db');
		mysqli_set_charset($conecta,'utf8');

		mysqli_query($conecta, "SET NAMES 'utf8'");
		mysqli_query($conecta, 'SET character_set_connection=utf8');
		mysqli_query($conecta, 'SET character_set_client=utf8');
		mysqli_query($conecta, 'SET character_set_results=utf8');

		return $conecta;		
	}
		

?>