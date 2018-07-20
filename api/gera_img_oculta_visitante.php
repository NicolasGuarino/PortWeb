<?php	
	require_once "conexao.php";
	include "imagem_oculta_etiqueta/funcao.php";

	$conexao = conectar();

	$documento_id = $_GET['documento_id'];
	$nome = $_GET['nome'];

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

	$query_documento = "update documento set imagem_oculta = '".$caminho_salvar."',  disponibilidade = 0 , ultima_atualizacao = now() where documento_id =". $documento_id;

	echo $query_documento;

	$documento  = mysqli_query($conexao, $query_documento) or die("Não foi possivel inserir o registro de documento<br/><b>Erro: " . mysqli_error($conexao) . "</b>");

?>