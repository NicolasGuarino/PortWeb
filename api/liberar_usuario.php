<?php  
	include 'conexao.php';

	header("Content-Type: text/html; charset=UTF-8", true);
	ini_set('default_charset', 'UTF-8');

	$conexao = conectar();

	$documento_id_pessoa = $_GET['documento_id_pessoa'];
	$documento_id_veiculo = $_GET['documento_id_veiculo'];
	$situacao_atual = $_GET['situacao_atual'];

	if($situacao_atual == '0'){

		$sql = "insert into rel_status_documento(status_documento_id, documento_id, hora) values (1,".$documento_id_pessoa.",now()),(1,".$documento_id_veiculo.",now());";
		echo "<br>".$sql;
		$insert = mysqli_query($conexao, $sql);

		$sql = "select * from rel_status_documento where documento_id = ".$documento_id_pessoa." or documento_id=".$documento_id_veiculo." order by rel_status_documento_id desc limit 2;";
		echo "<br>".$sql;
		$select2 = mysqli_query($conexao, $sql);
	
		while($rs = mysqli_fetch_array($select2)){
			$hora  = $rs['hora'];

			$update = "update documento set ultima_atualizacao= '" .$hora. "' where documento_id = " .$rs['documento_id'];
			echo "<br>".$sql;
			$query_update_hora  = mysqli_query($conexao, $update) or die("Não foi possivel inserir o registro de documento<br/><b>Erro: " . mysqli_error($conexao) . "</b>");
		}

	}else{

		$sql = "insert into rel_status_documento(status_documento_id, documento_id, hora) values (2,".$documento_id_pessoa.",now()),(1,".$documento_id_veiculo.",now());";
		echo "<br>".$sql;
		$insert = mysqli_query($conexao, $sql);

		$sql = "select * from rel_status_documento where documento_id = ".$documento_id_pessoa." or documento_id=".$documento_id_veiculo." order by rel_status_documento_id desc limit 2;";
		echo "<br>".$sql;
		$select2 = mysqli_query($conexao, $sql);
	
		while($rs = mysqli_fetch_array($select2)){
			$hora  = $rs['hora'];

			echo "<br>".$sql;
			$update = "update documento set ultima_atualizacao = '" .$hora. "' where documento_id = " .$rs['documento_id'];

			$query_update_hora  = mysqli_query($conexao, $update) or die("Não foi possivel inserir o registro de documento<br/><b>Erro: " . mysqli_error($conexao) . "</b>");
		}


	}	

?>