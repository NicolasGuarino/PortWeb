<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Gerenciamento de empresas </title>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/empresas_lista.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<script type="text/javascript" src="js/empresas_lista.js?0"></script>
	</head>

	<body>
		<div id="principal">
			<header>
				<div id="logo"></div>
				<label> Empresas cadastradas  </label>
				<?php include "fragments/menu.php" ?>
			</header>

			<div class="container_contador">
				<div class="icone"></div>
				<label> Empresas cadastradas </label>

				<div class="qtde_empresas">
					<label> 0 </label>
				</div>
			</div>

			<a href="cadastro_empresa.php" id="add_empresa" class="fa fa-plus"></a>
				

			<div id="lista_empresas">
				<div id="pesquisa">
					<input type="text" name="txt_pesquisa" id="campo_pesquisa" placheholder="Pesquisa..."/>
					<i class="fa fa-search" id="botao_pesquisa"></i>
				</div>

				<div class="seta" id="proximo"></div>
				<div class="seta" id="anterior"></div>
				
				<div id="empresas">
					<span class="lbl_nada_encontrado"> Nada Encontrado </span>
				</div>
			</div>

			<div id="logoSextou"></div>
		</div>
	</body>
</html>