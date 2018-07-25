<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> Cadastro de documentos </title>

		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/cadastro_documento.css">

		<script type="text/javascript" src="js/jquery-2.2.2.js"></script>	
		<script type="text/javascript" src="js/script.js"></script>	
		<script type="text/javascript" src="js/cadastro_documento.js"></script>	
	</head>
	
	<body>
		<body>
		<div id="corpo">
			<!-- HEADER -->
			<header>
				<div id="us_info">
					<span class="us_item"> Portaria	</span>
					<span class="us_item" id="us_tipo"> Cadastro de documentos </span>
					<a href="dashboard.php" id="ic_home" class="fa fa-home"> Dashboard </a>
				</div>

				<div id="centro">
					<div id="logo"> <!-- Logo --> </div>
				</div>

			</header>

			<div id="conteudo">
				<span class="tit"> Cadastro de documentos </span>

				<div id="formulario_cadastro">
					<form name="frm_cadastro_documento" method="post" action="cadastro_documento.php">
						<input type="number" name="txt_num_inicial" placeholder="Número inicial" class="form_txt" id="txt_num_inicial"/>
						<input type="number" name="txt_num_final" placeholder="Número final" class="form_txt" id="txt_num_final"/>

						<div id="caixa_radio">
							<input type="radio" name="radio_prefixo" class="radio_prefixo" value="C"/> Funcionário
							<input type="radio" name="radio_prefixo" class="radio_prefixo" value="A"/> Veiculo	
						</div>
						

						<input type="submit" name="btn_cadastrar" value="Cadastrar" class="form_btn" id="btn_cadastro"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>