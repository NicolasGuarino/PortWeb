<?php

		include 'conexao.php';

		header("Content-Type: text/html; charset=UTF-8", true);
		ini_set('default_charset', 'UTF-8');

		$conexao = conectar();
		$query .= "select ra.registro_acesso_id, u.nome, u.foto, ra.hora, u.usuario_id, ";
		$query .= "if((ra.hora between date_format(date_sub(now(), INTERVAL 60 SECOND), '%Y-%m-%d %H:%i:%s') and date_format(now(), '%Y-%m-%d %H:%i:%s')) and ra.responsavel_id = 35, 1, 0) as 'ativo' from registro_acesso as ra ";
		$query .= "inner join rel_registro_usuario as ru on(ru.registro_acesso_id=ra.registro_acesso_id) ";
		$query .= "inner join usuario as u on(u.usuario_id=ru.usuario_id)  ";
		$query .= "where ra.hora = u.ultima_atualizacao ";
		$query .= "group by u.usuario_id ";
		$query .= "order by ra.registro_acesso_id desc;";

		$select = mysqli_query($conexao, $query);
		
		$lista_usuario = [];
		$lista_id = [];

		while($rs = mysqli_fetch_array($select)){
			// echo array_search($rs['usuario_id'], $lista_id)."               ";
			if(array_search($rs['usuario_id'], $lista_id) === false) {
				$lista_id[] = $rs['usuario_id'];
				$lista_usuario[] = $rs;
				// echo "Novo id: ".$rs['usuario_id']."<br/>";
			}
		}

		echo json_encode($lista_usuario, JSON_UNESCAPED_UNICODE);
?>



