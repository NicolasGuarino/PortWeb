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
	</head>
	
	<body>
		<body>
		<div id="corpo">
			<!-- HEADER -->
			<header>
				<div id="us_info">
					<span class="us_item"> Portaria	</span>
					<span class="us_item" id="us_tipo"> Cadastro de empresas </span>
				</div>

				<div id="centro">
					<div id="logo"> <!-- Logo --> </div>
				</div>

			</header>

			<div id="conteudo">
				<span class="tit"> Cadastro de empresas </span>

				<div id="formulario_cadastro">
					<form name="frm_cadastro_empresa" method="post" action="cadastro_empresa.php">
						<input type="text" name="txt_nome" placeholder="Nome" class="form_txt" id="nome"/>

						<div class="upload_arquivo">
							<div id="nome_arquivo"></div>
							<button id="botao_upload"></button>
						</div>
						
						<input type="file" name="arquivo_foto" class="file" id="arquivo_foto"/>

						<input type="submit" name="btn_cadastrar" value="Cadastrar" class="form_btn" id="btn_cadastro"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>