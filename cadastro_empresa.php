<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Cadastro de empresas </title>
	
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/cadastro_empresa.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"	></script>	
		<script type="text/javascript" src="js/script.js"></script>	
		<script type="text/javascript" src="js/cadastro_empresa.js"></script>	
		<script type="text/javascript" src="js/editar_empresa.js"></script>	
	</head>
	
	<body>
		<div id="principal">
			<!-- HEADER -->
			<header>
				<div id="logo"></div>
				<label> Cadastro de empresa </label>

				<?php include "fragments/menu.php" ?>
			</header>

			<div class="container" id="login_container">
				<!-- <div class="container_logo"></div> -->

				<span class="container_tit"> <i class="fa fa-chevron-circle-left" id="voltar"></i> Cadastro de empresa </span>

				<form name="frm_cadastro_empresa" method="post" action="cadastro_empresa.php">
					<label class="lbl_container"> Nome </label>
					<input type="text" name="txt_nome" placeholder="Empresa LTDA" class="form_txt" id="nome"/>

					<label class="lbl_container"> Telefone/Celular </label>
					<input type="text" name="txt_telefone" placeholder="(xx)xxxxx-xxxx" class="form_txt" id="telefone" maxlength="14"/>

					<label class="lbl_container"> Email </label>
					<input type="text" name="txt_nome" placeholder="empresa@domino.com" class="form_txt" id="email"/>

					<label class="lbl_container"> Logo </label>
					<div class="upload_arquivo">
						<div id="nome_arquivo"></div>
						<i class="fa fa-cloud-upload" id="botao_upload"></i>
					</div>

					<input type="file" name="arquivo_foto" class="file" id="arquivo_foto"/>
					
					<input type="submit" name="btn_cadastrar" value="Cadastrar" class="form_btn" id="btn_cadastro"/>
				</form>
			</div>
		</div>
	</body>
</html>