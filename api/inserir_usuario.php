<?php
	date_default_timezone_set('America/Araguaina');
	require_once "conexao.php";
	include "imagem_oculta_etiqueta/funcao.php";
	include("../../libs/EnviarEmails/funcao.php");

	$conexao = conectar();

	$nome = addslashes($_REQUEST['nome']);
	$cpf = addslashes($_REQUEST['cpf']);
	$rg = addslashes($_REQUEST['rg']);
	$dt_nascimento = addslashes($_REQUEST['dt_nascimento']);
	$empresa = addslashes($_REQUEST['empresa']);
	$tipo_usuario = addslashes($_REQUEST['tipo_usuario']);
	$imagem = $_FILES['imagem'];
	$tel = addslashes($_REQUEST['tel']);
	$email = addslashes($_REQUEST['email']);
	
	$caminho = "img/";
	$caminho_upload = "../".$caminho.$imagem['name'];
	$caminho_banco  = $caminho.$imagem['name'];;

	// GERANDO A IMAGEM OCULTA
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

	if(move_uploaded_file($imagem['tmp_name'], $caminho_upload)) {
		$query = "select * from documento where disponibilidade = 1 and substring(numero_etiqueta, 1,1) = 'C' order by documento_id asc limit 1;";
		$result = mysqli_query($conexao, $query);
		$documento = json_encode(mysqli_fetch_array($result)['documento_id']);

		$hora = date('Y-m-d H:i:s');
		// INSERINDO USUÁRIO
		$query  = "insert into usuario(nome, cpf, data_nascimento, tipo_usuario_id, documento_id, foto, telefone, email, ultima_atualizacao, rg, login, senha) ";
		$query .= "values('".$nome."', '".$cpf."', '".$dt_nascimento."', ".$tipo_usuario.", ".$documento.", '".$caminho_banco."', '".$tel."', '".$email."', '".$hora."', '".$rg."', '".$email."', SHA1('s3nh@P@drao'));";

		$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));
	
		// PEGANDO O ULTIMO ID INSERIDO
		$usuario_id = mysqli_insert_id($conexao);

		$query = "insert into rel_status_usuario (status_id,usuario_id,hora) values (1, ".$usuario_id.", '".$hora."');";
		$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));

		$query = "insert into rel_empresa_funcionario (empresa_id,usuario_id) values (".$empresa.", ".$usuario_id.");";
		$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));

		$query = "update documento set imagem_oculta = '".$caminho_salvar."',  disponibilidade = 0 , ultima_atualizacao = '".$hora."' where documento_id =". $documento;
		$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));

		$query = "insert into rel_status_documento (status_documento_id, documento_id, hora) values (1, ".$documento.", '".$hora."');";
		$result = mysqli_query($conexao, $query) or die("Erro:" . mysqli_error($conexao));

		if($tipo_usuario == 3 || $tipo_usuario == 8) {
			$corpo = file_get_contents("../corpo_email/boas_vindas.html");
		
			$corpo = str_replace('$nome_usuario', $nome, $corpo);
			$corpo = str_replace('$id', $usuario_id, $corpo);
			$corpo = str_replace('$email', $email, $corpo);
			$parametrosEnvio = array('email_envio' => 'enigma@primi.com.br', 'senha' => 'jeferson@1010', 'nome_envio' => 'Portaria');
			
			$retorno = enviarEmail([$email], [], "Bem vindo!", $corpo, $parametrosEnvio);
			if($retorno['status'] == 1) $result = 1;
			
		}
	}else{
		$result = "Erro upload: " . $imagem['error'];
	}
	
	echo intval($result);

	mysqli_close($conexao);
?>