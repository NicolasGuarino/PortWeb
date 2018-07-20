<?php
	
	require_once "conexao.php";
	include "imagem_oculta_etiqueta/funcao.php";

	$tipo_usuario_id = $_GET['tipo_usuario_id'];
	$documento_id = $_GET['documento_id'];
	$ultima_atualizacao = $_GET['ultima_atualizacao'];
	$nome = $_GET['nome'];
	$telefone = $_GET['telefone'];
	//$data_nascimento = $_GET['data_nascimento'];
	$email = $_GET['email'];
	$tipo_etiqueta = $_GET['tipo_etiqueta'];
	$rg = $_GET['rg'];
	$foto = "";

	$conexao = conectar();

	// @require_once "imagem_oculta_etiqueta/index.php";
	// **************

	// Tempo máximo de execução
	set_time_limit(60);

	// Valor a ser gerado como imagem oculta
	$valor = strtoupper($nome);

	// Caminho e nome do arquivo
	$caminho_diretorio = "imagem_oculta_etiqueta/img_gerada/";

	// Nome do arquivo
	$nome_arquivo = microtime(true);
	$nome_arquivo = str_replace(".", "", $nome_arquivo);

	// Caminho completo
	$caminho_salvar = "./" . $caminho_diretorio . $nome_arquivo . ".png";

	// Gerando a imagem oculta
	$img = gerar_imagem_oculta($valor, "imagem_oculta_etiqueta/img/");

	// Salvando a imagem gerada
	imagepng($img, $caminho_salvar);
	imagedestroy($img);

	// **************

	/*$format = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';

	if ($data_nascimento != null && preg_match($format, $data_nascimento, $partes)) {
		$data_sql =  $partes[3].'-'.$partes[2].'-'.$partes[1];
	}*/


	$query   = "insert into usuario(tipo_usuario_id, documento_id, ultima_atualizacao, nome, rg, email, telefone) ";
	$query  .= "values(".$tipo_usuario_id.", ".$documento_id.", now(), '".$nome."', '".$rg."',  '".$email."', '".$telefone."');";

	//echo ($query);

	$result  = mysqli_query($conexao, $query) or die("Não foi possivel inserir o registro de funcionario<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

	$last_id = "set @id= LAST_INSERT_ID();";

		$result1  = mysqli_query($conexao, $last_id) or die("Não foi possivel inserir o registro de id usuario<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

    //echo ($result1);

	$status = "insert into rel_status_usuario (status_id,usuario_id,hora) values (1, @id, now());";

	$result2  = mysqli_query($conexao, $status) or die("Não foi possivel inserir o registro de status<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

	//   echo ($result2);

	$empresa = "insert into rel_empresa_funcionario (empresa_id,usuario_id) values (1, @id);";

	$result3  = mysqli_query($conexao, $empresa) or die("Não foi possivel inserir o registro de rel_empresa_funcionario<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

	//echo ($result3);

	$query_documento = "update documento set imagem_oculta = '".$caminho_salvar."',  disponibilidade = 0 , ultima_atualizacao = now() where documento_id =". $documento_id;

	//echo $query_documento;

	$documento  = mysqli_query($conexao, $query_documento) or die("Não foi possivel inserir o registro de documento<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

	/*$carro = "insert into rel_usuario_veiculo (usuario_id, veiculo_id) values ( @id, 10);";


	$query_carro  = mysqli_query($conexao, $carro) or die("Não foi possivel inserir o registro de documento<br/><b>Erro: " . mysqli_error($conexao) . "</b>");*/

	$rel_documento_status = "insert into rel_status_documento (status_documento_id, documento_id, hora) values (2, 12, now()), (2, ".$documento_id.", now());";

	$query_status  = mysqli_query($conexao, $rel_documento_status) or die("Não foi possivel inserir o registro de documento<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

	//echo ($query_status);

	$select_status = "select * from rel_status_documento where documento_id = 12 or documento_id=".$documento_id." order by rel_status_documento_id desc limit 2";

	$select2 = mysqli_query($conexao, $select_status);

	//echo ($select2);
	

		while($rs = mysqli_fetch_array($select2)){
			$hora  = $rs['hora'];

			$update = "update documento set ultima_atualizacao= '" .$hora. "' where documento_id = " .$rs['documento_id'];

			$query_update_hora  = mysqli_query($conexao, $update) or die("Não foi possivel inserir o registro de documento<br/><b>Erro: " . mysqli_error($conexao) . "</b>");
		}

	if($query){

		$return = "OK";
			
		// $return[0] = array(
				// "query" => "OK");
	}else{
		
		/*$return[0] = array(
				"query" => "ERRO");*/

				$return = "ERRO";
	}

	//echo json_encode($return, JSON_UNESCAPED_UNICODE);

	mysqli_close($conexao);

	echo json_encode($return);

		
?>

