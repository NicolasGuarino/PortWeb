<?php
	require "funcao.php";

	// header("Content-type: image/png");

	// Tempo máximo de execução
	set_time_limit(60);

	// Valor a ser gerado como imagem oculta
	$valor = $_GET['valor'];

	// Caminho e nome do arquivo
	$caminho_diretorio = "img_gerada/";

	// Nome do arquivo
	$nome_arquivo = microtime(true);
	$nome_arquivo = str_replace(".", "", $nome_arquivo);

	// Caminho completo
	$caminho_salvar = "./" . $caminho_diretorio . $nome_arquivo . ".png";
	// $caminho_salvar = $nome_arquivo . ".png";

	// Gerando a imagem oculta
	$img = gerar_imagem_oculta($valor, "img/");

	// Salvando a imagem gerada
	imagepng($img, $caminho_salvar);
	// imagepng($img);
	imagedestroy($img);

	// echo $caminho_salvar;

	// Imprimindo o caminho da imagem gerada
	// echo'{"resultado":true, "img":"'. $caminho_salvar .'"}';

	echo "<img style='width:auto;height:132.23px;' src='". $caminho_salvar ."' />";
?>